// Configuration constante du modal
const MODAL_CONFIG = {
    classes: {
        modal: 'modal',
        dialog: 'modal-dialog',
        content: 'modal-content',
        header: 'modal-header',
        title: 'modal-title',
        body: 'modal-body',
        footer: 'modal-footer',
        closeBtn: 'close',
        actionBtn: ['btn', 'btn_small', 'btn_outline']
    },
    attributes: {
        modal: {tabindex: '-1', role: 'dialog', 'aria-hidden': 'true'},
        closeBtn: {type: 'button', 'data-dismiss': 'modal', 'aria-label': 'Close'},
        actionBtn: {type: 'button', 'data-dismiss': 'modal'}
    }
};

// Templates réutilisables pour créer les éléments
const MODAL_TEMPLATES = {
    createElement(tag, classes, attributes = {}) {
        const el = document.createElement(tag);
        if (Array.isArray(classes)) {
            el.classList.add(...classes);
        } else if (classes) {
            el.classList.add(classes);
        }
        Object.entries(attributes).forEach(([key, value]) => {
            el.setAttribute(key, value);
        });
        return el;
    },

    createHeader(titleText, onClose) {
        const header = this.createElement('div', MODAL_CONFIG.classes.header);
        const title = this.createElement('h5', MODAL_CONFIG.classes.title);
        title.textContent = titleText;

        const closeBtn = this.createElement('button', MODAL_CONFIG.classes.closeBtn, MODAL_CONFIG.attributes.closeBtn);
        closeBtn.innerHTML = '<span aria-hidden="true">&times;</span>';
        closeBtn.addEventListener('click', onClose);

        header.appendChild(title);
        header.appendChild(closeBtn);
        return {header, closeBtn};
    },

    createBody(bodyText) {
        const body = this.createElement('div', MODAL_CONFIG.classes.body);
        body.textContent = bodyText;
        return body;
    },

    createFooter(buttonText, onClose) {
        const footer = this.createElement('div', MODAL_CONFIG.classes.footer);
        const btn = this.createElement('button', MODAL_CONFIG.classes.actionBtn, MODAL_CONFIG.attributes.actionBtn);
        btn.textContent = buttonText;
        btn.addEventListener('click', onClose);

        footer.appendChild(btn);
        return {footer, btn};
    }
};

// Données du contenu (séparé de la logique)
const modalContent = {
    title: "Information importante",
    body: "Ce site est un MVP (Minimum Viable Product) développé dans le cadre d’un projet de BUT Métiers du Multimédia et de l’Internet. Il a pour objectif de présenter les compétences acquises en développement web. Certaines fonctionnalités ne sont pas encore disponibles et le site est amené à évoluer.",
    closeButtonText: "C'est compris !"
};

// Fonction principale
function createModal(content) {
    const closeModal = () => {
        gsap.to(modal, {
            opacity: 0,
            duration: 0.3,
            ease: 'power2.out',
            onComplete: () => {
                document.body.removeChild(modal);
            }
        });

        gsap.to('.modal-dialog', {
            y: -50,
            duration: 0.3,
            ease: 'power2.in'
        });
    };

    // Créer la structure avec les templates
    const modal = MODAL_TEMPLATES.createElement('div', MODAL_CONFIG.classes.modal, MODAL_CONFIG.attributes.modal);
    const modalDialog = MODAL_TEMPLATES.createElement('div', MODAL_CONFIG.classes.dialog);
    const modalContentDiv = MODAL_TEMPLATES.createElement('div', MODAL_CONFIG.classes.content);

    const {header, closeBtn} = MODAL_TEMPLATES.createHeader(content.title, closeModal);
    const body = MODAL_TEMPLATES.createBody(content.body);
    const {footer} = MODAL_TEMPLATES.createFooter(content.closeButtonText, closeModal);

    // Assembler la structure
    modalContentDiv.appendChild(header);
    modalContentDiv.appendChild(body);
    modalContentDiv.appendChild(footer);
    modalDialog.appendChild(modalContentDiv);
    modal.appendChild(modalDialog);

    document.body.appendChild(modal);

    // Animation d'entrée avec GSAP
    gsap.fromTo(modal,
        {opacity: 0},
        {opacity: 1, duration: 0.3, ease: 'power2.out'}
    );

    gsap.fromTo(modalDialog,
        {y: -50, opacity: 0},
        {y: 0, opacity: 1, duration: 0.3, ease: 'power2.out'}
    );

    // Événements globaux
    document.addEventListener('click', (event) => {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeModal();
    });
}

// Exemple d'utilisation
//if (localStorage.getItem('modalShown') !== 'true' ) {
    createModal(modalContent);
    localStorage.setItem('modalShown', 'true');
//}