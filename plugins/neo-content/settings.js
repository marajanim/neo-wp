jQuery(function ($) {
  $('.neo-pick').on('click', function () {
    const input = $('#' + this.dataset.target);
    const frame = wp.media({ title: 'Choose image', library: { type: 'image' }, multiple: false });
    frame.on('select', () => {
      const file = frame.state().get('selection').first().toJSON();
      input.val(file.id);
      input.siblings('.neo-preview').empty().append($('<img>').attr({ src: file.sizes?.thumbnail?.url || file.url, alt: '' }).css('max-width', '150px'));
    });
    frame.open();
  });
  $('.neo-remove').on('click', function () { $('#' + this.dataset.target).val('').siblings('.neo-preview').empty(); });
});
