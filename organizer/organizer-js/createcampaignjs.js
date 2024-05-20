const dropArea = document.getElementById("drop-area");
const inputImage = document.getElementById("input-image");
const imageView = document.getElementsById("image-view");

inputImage.addEventListener("change", uploadImage);

function uploadImage(){
    let imgLink = URL.createObjectURL(inputImage.files[0]);
    imageView.style.backgroundImage = `url(${imgLink})`;
    imageView.textContent = ""; 
}

dropArea.addEventListener("dragover", (event) =>{
    e.preventDefault();
});

dropArea.addEventListener("drop", (event) =>{
    e.preventDefault();
    inputImage.files = e.dataTransfer.files;
    uploadImage();
});

// Char Count Title
function countTextTitle() {
  let text = document.getElementById("title").value
  document.getElementById('title-char').innerText = text.length;
  if (text.length == 100) {
    document.getElementById('title-max').setAttribute('style', 'color: #dc3545 !important');
  } else {
    document.getElementById('title-max').setAttribute('style', '');
  }
}

// Char Count Desc
function countTextDesc() {
  let text = document.getElementById("desc").value
  document.getElementById('desc-char').innerText = text.length;
  if (text.length == 3000) {
    document.getElementById('desc-max').setAttribute('style', 'color: #dc3545 !important');
  } else {
    document.getElementById('desc-max').setAttribute('style', '');
  }
}

// Char Count Organizer
function countTextOrganizer () {
  let text = document.getElementById("organizer").value
  document.getElementById('organizer-char').innerText = text.length;
  if (text.length == 50) {
    document.getElementById('organizer-max').setAttribute('style', 'color: #dc3545 !important');
  } else {
    document.getElementById('organizer-max').setAttribute('style', '');
  }
}

// Char Count Location
function countTextLoc () {
  let text = document.getElementById("loc").value
  document.getElementById('loc-char').innerText = text.length;
  if (text.length == 30) {
    document.getElementById('loc-max').setAttribute('style', 'color: #dc3545 !important');
  } else {
    document.getElementById('loc-max').setAttribute('style', '');
  }
}