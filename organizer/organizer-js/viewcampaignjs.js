// Browser Size
window.addEventListener('resize', widthResizer)

function widthResizer(){
    var view = window.innerWidth;
    var imageSize = document.getElementById('image-size')
    if (view > 1400) {
        document.getElementById('banner-container').setAttribute('style', 'height: 424px !important');
    } else if (view < 1400) {
        document.getElementById('banner-container').style.height =  imageSize.offsetHeight + 'px';
    }
}

// Comments Count
function countTextComment() {
  let text = document.getElementById("comment").value
  document.getElementById('comment-char').innerText = text.length;
  if (text.length == 1000) {
    document.getElementById('comment-max').setAttribute('style', 'color: #dc3545 !important');
  } else {
    document.getElementById('comment-max').setAttribute('style', '');
  }
}

