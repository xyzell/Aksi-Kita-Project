// Onload Page
document.getElementById('title-char').innerHTML = document.getElementById("title").value.length;
document.getElementById('desc-char').innerHTML = document.getElementById("desc").value.length;
document.getElementById('loc-char').innerHTML = document.getElementById("loc").value.length;

const title = document.getElementById("title").value;
const desc = document.getElementById("desc").value;
const loc = document.getElementById("loc").value;
const date = document.getElementById("date").value;

// Check Change
function titleChange() {
  let check = document.getElementById("title").value;
  if (check != title) {
    document.getElementById("title").setAttribute('class', 'w-100 rounded-3 border-info border-2 border border-opacity-50 bg-info bg-opacity-10 px-2 title-active-change fw-normal');
  } else {
    document.getElementById("title").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal');
  }
}

function descChange() {
  let check = document.getElementById("desc").value;
  if (check != desc) {
    document.getElementById("desc").setAttribute('class', 'w-100 rounded-3 border-info border-2 border border-opacity-50 bg-info bg-opacity-10 px-2 title-active-change h-desc fw-normal');
  } else {
    document.getElementById("desc").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active h-desc fw-normal');
  }
}

function locChange() {
  let check = document.getElementById("loc").value;
  if (check != loc) {
    document.getElementById("loc").setAttribute('class', 'w-100 rounded-3 border-info border-2 border border-opacity-50 bg-info bg-opacity-10 px-2 title-active-change fw-normal padding-tb');
  } else {
    document.getElementById("loc").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb');
  }
}

function dateChange(){
  let check = document.getElementById("date").value;
  if (check != date) {
    document.getElementById("date").setAttribute('class', 'w-100 rounded-3 border-info border-2 border border-opacity-50 bg-info bg-opacity-10 px-2 title-active-change fw-normal padding-tb');
  } else {
    document.getElementById("date").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb');
  }
}

// Drag & Drop Image
const dropArea = document.getElementById("drop-area");
const inputImage = document.getElementById("input-image");
const imageView = document.getElementById("image-view");

inputImage.addEventListener("change", uploadImage);

function uploadImage(){
    let imgLink = URL.createObjectURL(inputImage.files[0]);
    imageView.style.backgroundImage = `url(${imgLink})`;

    imageView.textContent = ""; 
    imageView.style.outlineColor = "#02bce0";
    imageView.style.backgroundColor = "#e6fafd";
    document.getElementById("undo-button").style.display = "inline";
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
        imageView.style.outlineColor = "#02bce0";
        imageView.style.backgroundColor = "#e6fafd";
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

// Undo Change
function undoImageChange() {
  document.getElementById("undo-button").style.display = "none";
  

  imageView.style.backgroundImage = "url('../assets/images/campaign/" + imageCheck + "')";
  imageView.style.outlineColor = "";
  imageView.style.backgroundColor = "";

  inputImage.value = "";
}

// Char Count Title
function countTextTitle() {
  let text = document.getElementById("title").value;
  titleChange();
  document.getElementById('title-char').innerText = text.length;
  if (text.length == 120) {
    document.getElementById('title-max').setAttribute('style', 'color: #dc3545 !important');
  } else {
    document.getElementById('title-max').setAttribute('style', '');
  }
}

// Char Count Desc
function countTextDesc() {
  let text = document.getElementById("desc").value;
  descChange();
  document.getElementById('desc-char').innerText = text.length;
  if (text.length == 3000) {
    document.getElementById('desc-max').setAttribute('style', 'color: #dc3545 !important');
  } else {
    document.getElementById('desc-max').setAttribute('style', '');
  }
}

// Char Count Location
function countTextLoc () {
  let text = document.getElementById("loc").value;
  locChange();
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
  window.scrollTo(0, 0);
}

// onclick after empty
function clickDate(){
  document.getElementById("date").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb');
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