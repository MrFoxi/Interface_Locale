const openModalButtons = document.querySelectorAll('[data-modal-target]');
const closeModalButtons = document.querySelectorAll('[data-close-button]');
const overlay = document.getElementById('overlay');

openModalButtons.forEach(button =>{
    button.addEventListener('click', () =>{
        //accède comme si c'était un objet JS et va chercher le "#modal" en html
        const modal = document.querySelector(button.dataset.modalTarget);
        openModal(modal)
    })
})

closeModalButtons.forEach(button =>{
    button.addEventListener('click', () =>{
        const modal = button.closest('.modal')//va chercher le parent (classe)
        closeModal(modal)
    })
})

overlay.addEventListener('click', () =>{
    const modals = document.querySelectorAll('.modal.active');
    modals.forEach(modal =>{
        closeModal(modal)
    })
})

function openModal(modal){
    if(modal == null) return;
    modal.classList.add('active')
    overlay.classList.add('active')
}

function closeModal(modal){
    if(modal == null) return;
    modal.classList.remove('active')
    overlay.classList.remove('active')
}