// Run against a disposable/local Neo WordPress site. Editing checks restore their values.
const { chromium } = require(process.env.PLAYWRIGHT_MODULE || 'playwright');
const fs = require('node:fs');
const path = require('node:path');
const os = require('node:os');
const assert = require('node:assert/strict');
const base = process.env.NEO_WORDPRESS_URL || 'http://neo.local';
const output = path.join(os.tmpdir(), 'neo-wordpress-review');
fs.mkdirSync(output, { recursive: true });
(async () => {
  const browser = await chromium.launch({ channel: 'chrome', headless: true });
  const report = { pages: [], editing: [] };
  try {
    for (const width of (process.env.NEO_EDIT_ONLY ? [] : [1440,390])) {
      const context = await browser.newContext({ viewport: { width, height: 900 }, reducedMotion: 'reduce' });
      const page = await context.newPage();
      for (const slug of ['', 'about/', 'products-services/', 'associates/', 'team-organogram/', 'gallery/', 'team-gallery/?category=service-engineering', 'training-gallery/', 'contact/']) {
        const errors=[]; const onError=error=>errors.push(error.message);
        page.on('pageerror', onError);
        const response=await page.goto(base+'/'+slug, {waitUntil:'networkidle'});
        assert.equal(response.status(),200,slug);
        const state=await page.evaluate(()=>({
          title:document.title,
          heading:document.querySelector('h1')?.textContent.trim(),
          overflow:document.documentElement.scrollWidth>innerWidth+2,
          pencil:!!document.querySelector('#neo-pencil-root'),
          broken:[...document.images].filter(i=>i.complete&&!i.naturalWidth&&i.loading!=='lazy').map(i=>i.src),
          nav:[...document.querySelectorAll('#primary-menu > a')].map(a=>({label:a.textContent.trim(),url:a.href}))
        }));
        assert(state.heading,slug+' missing heading');
        assert.equal(state.pencil,false);
        assert.deepEqual(errors,[],slug+' JavaScript errors');
        assert.deepEqual(state.broken,[],slug+' broken eager images');
        assert.equal(state.overflow,false,slug+' horizontal overflow');
        report.pages.push({slug,width,...state,errors});
        if(!slug) await page.screenshot({path:path.join(output,`home-${width}.png`)});
        page.off('pageerror',onError);
      }
      await context.close();
    }
    const visitor=await browser.newContext();
    const redirect=await visitor.request.get(base+'/?neo-pencil=1',{maxRedirects:0});
    assert.equal(redirect.status(),302);
    assert(redirect.headers().location.includes('wp-login.php'),'Edit link should send logged-out users to login');
    const denied=await visitor.request.post(base+'/wp-json/neo-pencil/v1/field',{data:{owner:0,key:'site_neo_index_210',value:'unauthorized'}});
    assert([401,403].includes(denied.status())); report.editing.push('Anonymous writes denied'); await visitor.close();
    if(process.env.NEO_WP_CREDENTIALS) {
      const credentials=JSON.parse(fs.readFileSync(process.env.NEO_WP_CREDENTIALS,'utf8'));
      const context=await browser.newContext({viewport:{width:1440,height:900},reducedMotion:'reduce'});
      await context.request.get(base+'/wp-login.php');
      await context.request.post(base+'/wp-login.php',{form:{log:credentials.username,pwd:credentials.password,'wp-submit':'Log In',redirect_to:base+'/wp-admin/',testcookie:'1'}});
      const page=await context.newPage();
      for (const width of [1440,390]) {
        await page.setViewportSize({width,height:900});
        await page.goto(base+'/',{waitUntil:'networkidle'});
        await page.locator('body').evaluate(el=>el.classList.add('cursor-ready'));
        await page.addStyleTag({content:'#wpadminbar{display:none!important}'});
        assert(await page.locator('.neo-pencil-launcher').isVisible(),'Launcher missing when admin bar is hidden');
        assert.equal(await page.locator('.neo-pencil-launcher').evaluate(el=>getComputedStyle(el).cursor),'pointer');
        await page.locator('.neo-pencil-launcher').click();
        await page.waitForURL(/neo-pencil=1/);
        await page.locator('#neo-pencil-root').waitFor({state:'attached'});
        await page.locator('#neo-pencil-root').getByRole('button',{name:'Done',exact:true}).waitFor();
        await page.locator('body').evaluate(el=>el.classList.add('cursor-ready'));
        await page.mouse.move(100,300);
        assert.notEqual(await page.locator('body').evaluate(el=>getComputedStyle(el).cursor),'none');
        assert.equal(await page.locator('[data-neo-field="neo_index_010"]').evaluate(el=>getComputedStyle(el).cursor),'pointer');
        await page.locator('[data-neo-field="neo_index_010"]').click();
        const textarea=page.locator('#neo-pencil-root').locator('textarea');
        await textarea.waitFor({state:'visible'});
        assert(await textarea.isVisible());
        assert.equal(await textarea.evaluate(el=>getComputedStyle(el).cursor),'text');
        await page.screenshot({path:path.join(output,`pencil-dialog-${width}.png`)});
        await page.locator('#neo-pencil-root').getByRole('button',{name:'Cancel',exact:true}).click();
        await page.locator('#neo-pencil-root').getByRole('button',{name:'Done',exact:true}).click();
        await page.waitForURL(url=>!url.searchParams.has('neo-pencil'));
        assert(await page.locator('.neo-pencil-launcher').isVisible());
      }
      report.editing.push('Desktop/mobile launcher works with hidden admin bar','Pointer and text cursors remain visible in edit mode','Logged-out edit link redirects to WordPress login');
      await page.setViewportSize({width:1440,height:900});
      await page.goto(base+'/?neo-pencil=1',{waitUntil:'networkidle'});
      assert(await page.locator('#neo-pencil-root').count(),'Authenticated Pencil did not load');
      const config=await page.evaluate(()=>window.neoPencil);
      const headers={'X-WP-Nonce':config.nonce};
      const key='neo_index_010';
      const url=config.endpoint+'?owner='+config.owner+'&key='+key;
      const original=await (await context.request.get(url,{headers})).json();
      let changed=false;
      try {
        const result=await context.request.post(config.endpoint,{headers,data:{owner:config.owner,key,revision:original.revision,value:'WORDPRESS PREVIEW TEST'}});
        assert.equal(result.status(),200); changed=true;
        const stale=await context.request.post(config.endpoint,{headers,data:{owner:config.owner,key,revision:original.revision,value:'STALE TEST'}});
        assert.equal(stale.status(),409);
        await page.reload({waitUntil:'networkidle'});
        assert.equal((await page.locator('[data-neo-field="'+key+'"]').innerText()).replace(/\s/g,''),'WORDPRESSPREVIEWTEST');
        report.editing.push('Authenticated database save persists after reload','Stale updates rejected');
      } finally {
        if(changed) {
          const fresh=await (await context.request.get(url,{headers})).json();
          const restore=await context.request.post(config.endpoint,{headers,data:{owner:config.owner,key,revision:fresh.revision,value:original.value}});
          assert.equal(restore.status(),200,'Restore failed');
        }
      }
      await page.reload({waitUntil:'networkidle'});
      await page.locator('[data-neo-field="'+key+'"]').click();
      await page.locator('#neo-pencil-root').locator('textarea').fill('CANCELLED PREVIEW');
      await page.locator('#neo-pencil-root').getByRole('button',{name:'Cancel',exact:true}).click();
      assert.equal(await page.locator('[data-neo-field="'+key+'"]').innerText(),original.value);
      await page.screenshot({path:path.join(output,'pencil-1440.png')});
      report.editing.push('Popup Cancel restores original text');
      await page.goto(base+'/wp-admin/post.php?post='+config.owner+'&action=edit',{waitUntil:'networkidle'});
      assert(await page.locator('.acf-field').count(),'ACF fields missing from page admin');
      report.editing.push('ACF Free fields present in WordPress admin');
      await context.close();
    }
    fs.writeFileSync(path.join(output,'verification.json'),JSON.stringify(report,null,2));
    console.log(JSON.stringify({passed:report.pages.length,editing:report.editing,output},null,2));
  } finally { await browser.close(); }
})().catch(error=>{console.error(error);process.exitCode=1;});
