// const inputImage = document.getElementById("profile-input");
// const imageView = document.getElementById("image");

// inputImage.addEventListener("change", uploadImage);

// function uploadImage() {
//     let imgLink = URL.createObjectURL(inputImage.files[0]);
//     imageView.src = `${imgLink}`;

//     document.getElementById("profil-change").submit();
// }

// test
const inputImage = document.getElementById("input-image");
const imageView = document.getElementById("image-view");

inputImage.addEventListener("change", uploadImage);

function uploadImage(){
    let imgLink = URL.createObjectURL(inputImage.files[0]);

    Swal.fire({
        title: "Are You Sure?",
        text: "Your profile picture will be changed",
        imageUrl: imgLink,
        showCancelButton: true,
        confirmButtonText: "Yes",
        focusCancel: true,
        customClass: {
            image: "rounded-circle image-size",
            title: 'title-modal',
            text: 'text-modal',
            cancelButton: 'btn rounded-pill border-0 bg-secondary bg-opacity-100 h-button mt-2 fw-bolder fs-6 text-white button-modal',
            confirmButton: 'btn rounded-pill border-0 bg-warning bg-opacity-100 h-button mt-2 fw-bolder fs-6 text-white button-modal'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("profile-change").submit();
        }
    });
}

// confirmation logout
function logoutClicked() {
    Swal.fire({
    title: "Are You Sure?",
     text: "You will be returned to the login screen",
     icon: "warning",
     showCancelButton: true,
    confirmButtonText: "Yes",
    focusCancel: true,
    customClass: {
     title: 'title-modal',
        text: 'text-modal',
        cancelButton: 'btn rounded-pill border-0 bg-secondary bg-opacity-100 h-button mt-2 fw-bolder fs-6 text-white button-modal',
        confirmButton: 'btn rounded-pill border-0 bg-danger bg-opacity-100 h-button mt-2 fw-bolder fs-6 text-white button-modal'
    }
    }).then((result) => {
    if (result.isConfirmed) {
        document.getElementById("logout").submit();
    }
  });
}