let deleteButtons = document.querySelectorAll('div.delete');
deleteButtons.forEach(button => {
    button.addEventListener('click', onDeleteClick);
});

let selectedID = 0;

function onDeleteClick() {
    selectedID = this.id;
    document.getElementById('popup2').style.display = 'block';
    blurBackground();
}

function blurBackground() {
    const body = document.getElementsByClassName('categoryScroll')[0];
    body.classList.add('blur');
}

function onYesClick() {
    let form = document.getElementById(`deleteForm${selectedID}`);
    form.submit();
}

function onNoClick() {
    const popup = document.getElementById('popup2');
    popup.style.display = 'none';
    unblurBackground();
}

function unblurBackground() {
    const body = document.getElementsByClassName('categoryScroll')[0];
    body.classList.remove('blur');
}
