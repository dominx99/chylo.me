var images = document.querySelectorAll('img.big-picture');

Array.prototype.forEach.call(images, function(item, i) {
    item.addEventListener('click', function(e){
        e.preventDefault();

        var gallery = null;

        if (!e.target.classList.contains('single')) {
            gallery = '.big-picture-gallery';
        }

        BigPicture({
          el: this,
          imgSrc: this.getAttribute('data-src'),
          gallery: gallery
        });
    });
});
