const nama = document.getElementById("name").value;
const web = document.getElementById("web").value;
const phone = document.getElementById("phone").value;
const desc = document.getElementById("desc").value;

function nameChange() {
    let check = document.getElementById("name").value;
    if (check != nama) {
        document.getElementById("name").setAttribute('class', 'w-100 rounded-3 border-info border-2 border border-opacity-50 bg-info bg-opacity-10 px-2 title-active-change fw-normal');
    } else {
        document.getElementById("name").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal');
    }
}

function webChange() {
    let check = document.getElementById("web").value;
    if (check != web) {
        document.getElementById("web").setAttribute('class', 'w-100 rounded-3 border-info border-2 border border-opacity-50 bg-info bg-opacity-10 px-2 title-active-change fw-normal');
    } else {
        document.getElementById("web").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal');
    }
}

function phoneChange() {
    let check = document.getElementById("phone").value;
    if (check != phone) {
        document.getElementById("phone").setAttribute('class', 'w-100 rounded-3 border-info border-2 border border-opacity-50 bg-info bg-opacity-10 px-2 title-active-change fw-normal');
    } else {
        document.getElementById("phone").setAttribute('class', 'w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal');
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

