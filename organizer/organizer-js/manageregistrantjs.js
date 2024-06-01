var modals = document.querySelectorAll(".profile-modal");
var btns = document.querySelectorAll(".open-modal");

btns.forEach(function(btn) {
  btn.onclick = function() {
    var modalId = this.getAttribute("data-modal-id");
    var modal = document.getElementById(modalId);
    modal.style.display = "flex";
    setTimeout(() => {
      modal.classList.add("show");
      modal.classList.remove("hide");
    }, 10);
  }
});

window.onclick = function(event) {
  if (event.target.classList.contains('profile-modal')) {
    var modal = event.target;
    modal.classList.add("hide");
    modal.classList.remove("show");
    setTimeout(() => modal.style.display = "none", 500);
  }
}

document.onkeydown = function(event) {
  if (event.key === "Escape") {
    modals.forEach(function(modal) {
      modal.classList.add("hide");
      modal.classList.remove("show");
      setTimeout(() => modal.style.display = "none", 500);
    });
  }
}
