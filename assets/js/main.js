(function () {
  // offline detection
  document.querySelectorAll('.ratio img.card-img, .ratio video.card-img').forEach(function (el) {
    el.addEventListener('error', function () {
      var card = this.closest('.card');
      if (!card) return;
      var overlay = card.querySelector('.card-img-overlay');
      if (overlay) overlay.classList.remove('d-none');
    });

    if (el.tagName === 'IMG' && el.complete && el.naturalWidth === 0) {
      var card = el.closest('.card');
      if (!card) return;
      var overlay = card.querySelector('.card-img-overlay');
      if (overlay) overlay.classList.remove('d-none');
    }
  });

  // auto-refresh
  document.querySelectorAll('[data-refresh]').forEach(function (card) {
    var interval = parseInt(card.getAttribute('data-refresh'), 10);
    if (!interval || interval < 5) return;

    setInterval(function () {
      var img = card.querySelector('img.card-img');
      if (img) {
        var src = img.src.split('?')[0];
        img.src = src + '?_=' + Date.now();
      }

      var iframe = card.querySelector('iframe.js-refresh-iframe');
      if (iframe) {
        var src = iframe.src.split('?')[0];
        iframe.src = src + '?_=' + Date.now();
      }

      var metarEl = card.querySelector('[data-metar-code]');
      if (metarEl) {
        var code = metarEl.getAttribute('data-metar-code');
        fetch('index.php?op=metar&code=' + encodeURIComponent(code))
          .then(function (r) { return r.text(); })
          .then(function (text) {
            var raw = metarEl.querySelector('.metar-raw');
            if (raw) raw.textContent = text;
            var time = metarEl.querySelector('.metar-time');
            if (time) time.textContent = new Date().toLocaleTimeString();
          })
          .catch(function () {});
      }

      var notamEl = card.querySelector('[data-notam-code]');
      if (notamEl) {
        var code = notamEl.getAttribute('data-notam-code');
        fetch('index.php?op=notam&code=' + encodeURIComponent(code))
          .then(function (r) { return r.text(); })
          .then(function (text) {
            var raw = notamEl.querySelector('.notam-raw');
            if (raw) raw.textContent = text;
            var time = notamEl.querySelector('.notam-time');
            if (time) time.textContent = new Date().toLocaleTimeString();
            var count = notamEl.querySelector('.notam-count');
            if (count) count.textContent = (text.match(/\n/g) || []).length + 1 + ' NOTAM';
          })
          .catch(function () {});
      }
    }, interval * 1000);
  });
})();
