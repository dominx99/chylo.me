var button = document.getElementById('navbar-toggle'),
    el     = document.getElementById('navbar'),
    md     = 768;


function toggle(){
    toggleClass(el, 'sidebar');
}

function close(){
    removeClass(el, 'sidebar');
}

function resize(){
    if(md_width()) close();
}

function md_width(){
    if(window.innerWidth > md) return true;
    return false;
}

function removeClass(el, className){
    if (el.classList)
      el.classList.remove(className);
    else
      el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
}

function toggleClass(el, className){
    if (el.classList) {
      el.classList.toggle(className);
    } else {
      var classes = el.className.split(' ');
      var existingIndex = classes.indexOf(className);

      if (existingIndex >= 0)
        classes.splice(existingIndex, 1);
      else
        classes.push(className);

      el.className = classes.join(' ');
    }
}

window.addEventListener('resize', resize);
button.addEventListener('click', toggle);
