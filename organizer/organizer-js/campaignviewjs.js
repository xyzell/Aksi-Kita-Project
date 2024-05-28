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

// reload page
function reload() {
  location.reload();
}

// Campaign Delete
function deleteCampaign() {
  Swal.fire({
  title: "Are you sure?",
  text: "Do you really sure want to delete this campaign? This process cannot be undone",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "Yes",
  focusCancel: true,
  customClass: {
    title: 'title-modal',
    text: 'text-modal',
    cancelButton: 'btn rounded-pill border-0 bg-secondary bg-opacity-100 mt-2 fw-bolder fs-6 text-white button-modal',
    confirmButton: 'btn rounded-pill border-0 bg-danger bg-opacity-100 mt-2 fw-bolder fs-6 text-white button-modal'
  }
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Campaign Sucessfully Deleted!",
        text: "Your campaign has been deleted.",
        icon: "success",
        confirmButtonText: "Yes",
        customClass: {
          title: 'title-modal',
          text: 'text-modal',
          confirmButton: 'btn rounded-pill border-0 bg-danger bg-opacity-100 h-button mt-2 fw-bolder fs-6 text-white button-modal'
        }
      }).then(() => {
        deleteConfirmed();
      });
    }
  });
}

function deleteConfirmed() {
    document.getElementById("form-delete").submit();
}

