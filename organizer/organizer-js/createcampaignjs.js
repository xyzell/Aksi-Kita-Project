// Drag & Drop Image
const dropArea = document.getElementById("drop-area");
const inputImage = document.getElementById("input-image");
const imageView = document.getElementById("image-view");

inputImage.addEventListener("change", uploadImage);

function uploadImage(){
    let imgLink = URL.createObjectURL(inputImage.files[0]);
    imageView.style.backgroundImage = `url(${imgLink})`;
    imageView.textContent = ""; 
}

dropArea.addEventListener("dragenter", (e) => {
    e.preventDefault();
    imageView.style.outlineColor = "rgba(255, 193, 7, 0.50)";
    imageView.style.backgroundColor = "rgba(255, 193, 7, 0.1)";
});

dropArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    imageView.style.outlineColor = "rgba(255, 193, 7, 0.50)";
    imageView.style.backgroundColor = "rgba(255, 193, 7, 0.1)";
});

dropArea.addEventListener("dragleave", (e) => {
    e.preventDefault();
    imageView.style.outlineColor = "";
    imageView.style.backgroundColor = "";
});

dropArea.addEventListener("drop", (e) =>{
    e.preventDefault(); 
    var check = document.getElementById("check");;
    check.files = e.dataTransfer.files;

    if(check.files[0].type.match('image.*')){
      if(check.files.length == 1){
        inputImage.files = e.dataTransfer.files;
        inputImage.dispatchEvent(new Event('change'));
        imageView.style.outlineColor = "";
        imageView.style.backgroundColor = "";
      } else {
        imageView.style.outlineColor = "";
        imageView.style.backgroundColor = "";
        lotOfFiles();
      }
    } else {
      imageView.style.outlineColor = "";
      imageView.style.backgroundColor = "";
      image();
    }
});

// Char Count Title
function countTextTitle() {
  let text = document.getElementById("title").value;
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
  if (text.length == 40) {
    document.getElementById('loc-max').setAttribute('style', 'color: #dc3545 !important');
  } else {
    document.getElementById('loc-max').setAttribute('style', '');
  }
}

// empty file
function noImage (){
   imageView.style.outlineColor = "rgba(220, 53, 69, 0.5)";
   imageView.style.backgroundColor = "rgba(220, 53, 69, 0.1)";
}

function noTitle(){
  document.getElementById("title").setAttribute('class', 'w-100 rounded-3 border-danger border-2 border border-opacity-50 bg-danger bg-opacity-10 px-2 title-active fw-normal');
}

function noDesc(){
  document.getElementById("desc").setAttribute('class', 'w-100 rounded-3 border-danger border-2 border border-opacity-50 bg-danger bg-opacity-10 px-2 title-active h-desc fw-normal');
}

function noDate(){
  document.getElementById("date").setAttribute('class', 'w-100 rounded-3 border-danger border-2 border border-opacity-50 bg-danger bg-opacity-10 px-2 title-active fw-normal padding-tb');
}

function noLocation(){
  document.getElementById("loc").setAttribute('class', 'w-100 rounded-3 border-danger border-2 border border-opacity-50 bg-danger bg-opacity-10 px-2 title-active fw-normal padding-tb');
}

// onclick after empty
function clickTitle(){
  document.getElementById("title").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal');
}

function clickDesc(){
  document.getElementById("desc").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active h-desc fw-normal');
}

function clickDate(){
  document.getElementById("date").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb');
}

function clickLocation(){
  document.getElementById("loc").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb');
}

// error image
function image() {
  Swal.fire({
  icon: "error",
  title: "Error!",
  text: "Only Image is Allowed",
  buttonsStyling: false,
  customClass: {
    title: 'title-modal',
    text: 'text-modal',
    confirmButton: 'btn rounded-pill border-0 bg-warning bg-opacity-75 h-button mt-2 fw-bolder fs-6 text-white button-modal'
  }
});
}

function lotOfFiles() {
  Swal.fire({
  icon: "error",
  title: "Error!",
  text: "Only 1 Image File is Allowed",
  buttonsStyling: false,
  customClass: {
    title: 'title-modal',
    text: 'text-modal',
    confirmButton: 'btn rounded-pill border-0 bg-warning bg-opacity-75 h-button mt-2 fw-bolder fs-6 text-white button-modal'
  }
});
}