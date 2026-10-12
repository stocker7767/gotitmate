(function(){document.addEventListener('click',function(e){var el=e.target.closest('[data-gim-confirm]');if(el&&!window.confirm(el.getAttribute('data-gim-confirm')))e.preventDefault();});})();
