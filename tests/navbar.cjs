// Local WordPress regression: toolbar/header must not overlap at any scroll state.
const { chromium } = require(process.env.PLAYWRIGHT_MODULE || 'playwright');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const os = require('node:os');
const base = process.env.NEO_WORDPRESS_URL || 'http://neo.local';
const output = path.join(os.tmpdir(),'neo-navbar-review');
fs.mkdirSync(output,{recursive:true});
(async () => {
  const browser = await chromium.launch({channel:'chrome',headless:true});
  const results=[];
  try {
    for (const authenticated of [false,true]) {
      const context=await browser.newContext();
      if (authenticated) {
        const credentials=JSON.parse(fs.readFileSync(process.env.NEO_WP_CREDENTIALS,'utf8'));
        await context.request.get(base+'/wp-login.php');
        await context.request.post(base+'/wp-login.php',{form:{log:credentials.username,pwd:credentials.password,'wp-submit':'Log In',redirect_to:base+'/',testcookie:'1'}});
      }
      const page=await context.newPage();
      for (const width of [1872,1440,980,782,600,390]) {
        await page.setViewportSize({width,height:900});
        await page.goto(base+'/',{waitUntil:'networkidle'});
        if (authenticated) assert.equal(await page.locator('#wpadminbar').count(),1);
        for (const scroll of [0,100,3800,0]) {
          await page.evaluate(y=>window.scrollTo(0,y),scroll);
          await page.waitForTimeout(350);
          const geometry=await page.evaluate(()=> {
            const header=document.querySelector('.site-header');
            const rect=header.getBoundingClientRect();
            const toolbar=document.getElementById('wpadminbar')?.getBoundingClientRect();
            return {headerTop:rect.top,headerBottom:rect.bottom,toolbarBottom:Math.max(0,toolbar?.bottom||0),scrolled:header.classList.contains('is-scrolled')};
          });
          assert(geometry.headerTop>=geometry.toolbarBottom+6,JSON.stringify({authenticated,width,scroll,...geometry}));
          assert(geometry.headerBottom<900,'Header must stay within the viewport');
          results.push({authenticated,width,scroll,...geometry});
          if(authenticated&&width===1872&&scroll===3800) await page.screenshot({path:path.join(output,'logged-in-scrolled.png')});
        }
        if (authenticated) {
          await page.addStyleTag({content:'#wpadminbar{display:none!important}'});
          await page.evaluate(()=>window.scrollTo(0,1000));
          await page.waitForTimeout(350);
          const top=await page.locator('.site-header').evaluate(el=>el.getBoundingClientRect().top);
          assert(Math.abs(top-8)<2,'Hidden toolbar should not leave a blank toolbar offset');
        }
      }
      await context.close();
    }
    fs.writeFileSync(path.join(output,'results.json'),JSON.stringify(results,null,2));
    console.log(JSON.stringify({passed:results.length,hiddenToolbarChecks:6,output}));
  } finally {await browser.close();}
})().catch(error=>{console.error(error);process.exitCode=1;});
