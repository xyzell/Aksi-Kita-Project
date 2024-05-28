document.addEventListener('DOMContentLoaded', (event) => {
    const modal = document.getElementById("modalForm");
    const successModal = document.getElementById("successModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModal = document.getElementsByClassName("custom-close");
    const submitBtn = document.getElementById("submitBtn");
    const volunteerForm = document.getElementById("volunteerForm");
    const closeSuccessModalBtn = document.getElementById("closeSuccessModalBtn");

    openModalBtn.onclick = function() {
        modal.style.display = "block";
    }

    Array.from(closeModal).forEach(element => {
        element.onclick = function() {
            modal.style.display = "none";
            successModal.style.display = "none";
        }
    });

    closeSuccessModalBtn.onclick = function() {
        successModal.style.display = "none";
        window.location.href = 'aksiRelawan.php';  // Ganti dengan halaman sebelumnya
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == successModal) {
            successModal.style.display = "none";
            window.location.href = 'aksiRelawan.php';  // Ganti dengan halaman sebelumnya
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
        event.preventDefault();
        
        const formData = new FormData(volunteerForm);
        
        fetch('joinCampaign.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes('New record created successfully')) {
                modal.style.display = "none";
                successModal.style.display = "block";
            } else {
                alert('Error: ' + data);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
