(() => {
  const config = window.neoPencil;
  if (!config) return;
  const root = document.createElement('div');
  root.id = 'neo-pencil-root';
  const shadow = root.attachShadow({ mode: 'open' });
  shadow.innerHTML = `<style>
    :host{font:14px/1.5 system-ui;color:#1f1634;cursor:auto}*{box-sizing:border-box}
    .bar{position:fixed;bottom:20px;left:20px;z-index:2147483600;display:flex;gap:16px;align-items:center;background:#fff;border:1px solid #e2d6f6;border-radius:12px;padding:12px 16px;box-shadow:0 8px 36px #0003}
    button{font:inherit;cursor:pointer;border:1px solid #ded4ee;border-radius:7px;background:white;padding:8px 14px;color:inherit}button.primary{background:#7729cf;border-color:#7729cf;color:#fff}button:disabled{opacity:.6;cursor:wait}
    dialog{position:fixed;margin:auto;border:1px solid #dfd1f1;border-radius:14px;padding:22px;width:min(420px,calc(100vw - 28px));box-shadow:0 18px 80px #0004;max-height:85vh;overflow:auto;color:inherit;background:#fff}
    dialog::backdrop{background:#160c2422}h2{font-size:16px;margin:0 0 8px}.scope{font-size:12px;color:#695a7b;margin-bottom:12px}textarea{font:inherit;resize:vertical;width:100%;min-height:120px;padding:10px;border:1px solid #a379d1;border-radius:7px;cursor:text}textarea:focus{outline:2px solid #c99af8}.actions{display:flex;justify-content:flex-end;gap:8px;margin-top:14px}.error{color:#ad123b;white-space:pre-wrap;margin-top:8px}img{max-width:100%;max-height:220px}.toast{position:fixed;bottom:85px;left:20px;background:#251533;color:#fff;padding:10px 16px;border-radius:9px;z-index:2147483601}
    @media(max-width:480px){.bar{left:12px;right:12px;bottom:12px;gap:10px;padding:10px}.bar span{font-size:12px}.bar button{margin-left:auto}}
    </style><div class="bar"><strong>✎ Pencil</strong><span>Click text or an image</span><button id="done">Done</button></div>
    <dialog aria-labelledby="title"><h2 id="title"></h2><div class="scope"></div><textarea aria-label="Text"></textarea><div class="media" hidden><img alt="Selected image"><button id="choose">Choose image</button></div><div class="error" role="alert"></div><div class="actions"><button id="cancel">Cancel</button><button id="save" class="primary">Save to website</button></div></dialog><div class="toast" role="status" hidden></div>`;
  document.body.append(root);
  const style = document.createElement('style');
  style.textContent = '[data-neo-field]:hover,[data-neo-image]:hover{outline:2px solid #8b42da!important;outline-offset:4px;cursor:pointer!important}[data-neo-field]:empty{display:inline-block;min-width:24px;min-height:18px;outline:1px dashed #8b42da}.cursor{display:none!important}';
  document.head.append(style);
  const dialog = shadow.querySelector('dialog');
  const textarea = shadow.querySelector('textarea');
  const media = shadow.querySelector('.media');
  const error = shadow.querySelector('.error');
  const save = shadow.querySelector('#save');
  let active, draft, saving = false, toastTimer;
  async function request(method, data) {
    const url = new URL(config.endpoint);
    if (method === 'GET') Object.entries(data).forEach(([key, value]) => url.searchParams.set(key,value));
    const response = await fetch(url, { method, credentials:'same-origin', headers:{'X-WP-Nonce':config.nonce,'Content-Type':'application/json'}, ...(method==='POST'?{body:JSON.stringify(data)}:{}) });
    const result = await response.json();
    if (!response.ok) throw new Error(result.message || 'The change could not be saved.');
    return result;
  }
  function cancel() {
    if (saving) return;
    if (active) {
      if (active.image) { active.element.replaceWith(active.original); }
      else active.element.innerHTML = active.original;
    }
    active = null; dialog.close();
  }
  async function open(event) {
    const element = event.target.closest('[data-neo-field],[data-neo-image]');
    if (!element || dialog.open || event.target.closest('#neo-pencil-root')) return;
    event.preventDefault(); event.stopImmediatePropagation();
    const key = element.dataset.neoField || element.dataset.neoImage;
    const owner = element.dataset.neoOwner ?? element.closest('footer')?.dataset.neoOwner ?? config.owner;
    try {
      const field = await request('GET',{owner,key});
      active = { element,owner,key,field,image:!!element.dataset.neoImage, original:element.dataset.neoImage?element.cloneNode(true):element.innerHTML };
      draft = field.value; textarea.value = field.value;
      shadow.querySelector('#title').textContent = field.label;
      shadow.querySelector('.scope').textContent = Number(owner) === 0 ? 'Site-wide content · Save publishes immediately' : 'Page content · Save publishes immediately';
      textarea.hidden = active.image; media.hidden = !active.image;
      media.querySelector('img').src = field.url || '';
      error.textContent = ''; dialog.showModal();
      (active.image ? shadow.querySelector('#choose') : textarea).focus();
    } catch (exception) { toast(exception.message); }
  }
  function toast(text) { const element=shadow.querySelector('.toast'); element.textContent=text; element.hidden=false; clearTimeout(toastTimer); toastTimer=setTimeout(()=>element.hidden=true,5000); }
  document.addEventListener('click',open,true);
  textarea.addEventListener('input',()=> { draft=textarea.value; active.element.textContent=draft; });
  shadow.querySelector('#choose').addEventListener('click',()=> {
    // The native media modal lives outside the shadow dialog/top layer.
    dialog.close();
    const frame = wp.media({title:'Choose image',library:{type:'image'},multiple:false});
    frame.on('select',()=> {
      const file=frame.state().get('selection').first().toJSON(); draft=file.id;
      media.querySelector('img').src=file.url; active.element.src=file.url; active.element.removeAttribute('srcset'); active.element.alt=file.alt || '';
    });
    frame.on('close',()=>dialog.showModal()); frame.open();
  });
  shadow.querySelector('#cancel').addEventListener('click',cancel);
  dialog.addEventListener('cancel',event=> {event.preventDefault();cancel();});
  save.addEventListener('click',async()=> {
    if (!active || saving) return;
    saving=true; save.disabled=true; error.textContent='';
    try {
      const result=await request('POST',{owner:active.owner,key:active.key,revision:active.field.revision,value:draft});
      if (active.image) {active.element.src=result.url;active.element.srcset=result.srcset;active.element.alt=result.alt;}
      else { active.element.textContent=result.value; active.element.style.whiteSpace='pre-line'; }
      active=null; dialog.close(); toast('Saved to WordPress. Reload to replay page animations.');
    } catch(exception) {error.textContent=exception.message;}
    finally {saving=false;save.disabled=false;}
  });
  textarea.addEventListener('keydown',event=> {if((event.ctrlKey||event.metaKey)&&event.key==='Enter'){event.preventDefault();save.click();}});
  shadow.querySelector('#done').addEventListener('click',()=> {const url=new URL(location.href);url.searchParams.delete('neo-pencil');location.href=url.href;});
})();
