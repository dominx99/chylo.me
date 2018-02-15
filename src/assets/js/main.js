var images = document.querySelectorAll('img.big-picture');

Array.prototype.forEach.call(images, function(item, i){
    item.addEventListener('click', function(){
        BigPicture({
          el: this,
          imgSrc: this.getAttribute('data-src')
        });
    });
});
