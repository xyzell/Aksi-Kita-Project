document.addEventListener('DOMContentLoaded', (event) => {
    const modal = document.getElementById("modalForm");
    const successModal = document.getElementById("successModal");
    const alreadyRegisteredModal = document.getElementById("alreadyRegisteredModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalElements = document.getElementsByClassName("unique-custom-close");
    const submitBtn = document.getElementById("submitBtn");
    const volunteerForm = document.getElementById("volunteerForm");
    const closeSuccessModalBtn = document.getElementById("unique-closeSuccessModalBtn");
    const closeAlreadyRegisteredModalBtn = document.getElementById("closeAlreadyRegisteredModalBtn");

    const contactModal = document.getElementById("contactModal");
    const contactOrganizerBtn = document.getElementById("contactOrganizerBtn");

    function showModal(modalElement) {
        modalElement.classList.remove('hide');
        modalElement.classList.add('show');
        modalElement.style.display = 'flex'; // Ensure the modal uses flexbox
    }

    function hideModal(modalElement) {
        modalElement.classList.remove('show');
        modalElement.classList.add('hide');
        setTimeout(() => {
            modalElement.style.display = 'none';
        }, 500);
    }

    openModalBtn.onclick = function() {
        if (alreadyRegistered) {
            showModal(alreadyRegisteredModal);
        } else {
            showModal(modal);
        }
    }

    contactOrganizerBtn.onclick = function() {
        showModal(contactModal);
    }

    Array.from(closeModalElements).forEach(element => {
        element.onclick = function() {
            hideModal(modal);
            hideModal(successModal);
            hideModal(contactModal);
            hideModal(alreadyRegisteredModal);
        }
    });

    closeSuccessModalBtn.onclick = function() {
        hideModal(successModal);
        setTimeout(() => {
            window.location.href = 'cariAksi.php';  // Ganti dengan halaman sebelumnya
        }, 500);
    }

    closeAlreadyRegisteredModalBtn.onclick = function() {
        hideModal(alreadyRegisteredModal);
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            hideModal(modal);
        }
        if (event.target == successModal) {
            hideModal(successModal);
            setTimeout(() => {
                window.location.href = 'cariAksi.php';  // Ganti dengan halaman sebelumnya
            }, 500);
        }
        if (event.target == contactModal) {
            hideModal(contactModal);
        }
        if (event.target == alreadyRegisteredModal) {
            hideModal(alreadyRegisteredModal);
        }
    }

    volunteerForm.addEventListener('input', function() {
        const desc1 = document.getElementById('question1').value.trim();
        const desc2 = document.getElementById('question2').value.trim();

        if (desc1 && desc2) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    });

    volunteerForm.addEventListener('submit', function(event) {
        if (!userLoggedIn) {
            alert("Silakan login terlebih dahulu untuk mendaftar ke kampanye ini.");
            window.location.href = 'login.php';
            return; // Hentikan pengiriman formulir
        }

        event.preventDefault();
        
        const formData = new FormData(volunteerForm);
        
        fetch('joinCampaign.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes('New record created successfully')) {
                hideModal(modal);
                showModal(successModal);
            } else {
                alert('Error: ' + data);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Check user registration status and login status
    if (!userLoggedIn || alreadyRegistered) {
        submitBtn.disabled = true;
    }
});
