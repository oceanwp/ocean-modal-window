import OW_Base from "./base/base";
import { fadeIn, fadeOut } from "./lib/utils";
import delegate from "delegate";

class OW_ModalWindow extends OW_Base {
    modal;

    getDefaultSettings() {
        return {
            selectors: {
                modalWindow: ".omw-modal",
                modalWindowOpenButtons:
                    ".omw-open-modal, .omw-open-modal a, .omw-open-modal a.elementor-button, li.sidr-class-omw-open-modal > a, li.sidr-class-opl-login-li > a",
                modalWindowCloseBtn: ".omw-close-modal",
                overlay: ".omw-modal-overlay",
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings("selectors");

        return {
            modalWindow: document.querySelector(selectors.modalWindow),
            modalWindowOpenButtons: document.querySelectorAll(selectors.modalWindowOpenButtons),
            modalWindowCloseBtn: document.querySelector(selectors.modalWindowCloseBtn),
            overlay: document.querySelector(selectors.overlay),
            body: document.body,
        };
    }

    onInit() {
        super.onInit();

        if (!!this.elements.modalWindow) {
            this.initPerfectScrollbar();
        }
    }

    bindEvents() {
        if (!this.elements.modalWindow) {
            return;
        }

        this.elements.modalWindowOpenButtons.forEach((modalOpenBtn) => {
            modalOpenBtn.addEventListener("click", this.openModal.bind(this));
        });

        delegate(document.body, ".omw-close-modal", "click", this.closeModal.bind(this));
        this.elements.overlay.addEventListener("click", this.closeModal.bind(this));

        window.addEventListener("keyup", this.onWindowKeyup.bind(this));
    }

    openModal(event) {
        event.preventDefault();
        event.stopPropagation();

        const modalOpenBtn = event.currentTarget;
        const modalID = modalOpenBtn.getAttribute("href");
        this.modal = document.querySelector(modalID);

        if (!!this.modal) {
            this.elements.body.classList.add(this.modal.id);
            fadeIn(this.elements.overlay);
            fadeIn(this.modal);
            this.modal.classList.add("omw-open");
        }
    }

    closeModal(event) {
        event.preventDefault();

        if (!this.modal) {
            return;
        }

        if (!this.modal.classList.contains("omw-open")) {
            return;
        }

        fadeOut(this.elements.overlay);
        fadeOut(this.modal);
        this.modal.classList.remove("omw-open");

        // Stop video
        const iframes = this.modal.querySelectorAll("iframe");

        if (!!iframes) {
            iframes.forEach((iframe) => {
                iframe.src = iframe.src;
            });
        }

        setTimeout(() => {
            this.elements.body.classList.remove(this.modal.id);
        }, 300);
    }

    onWindowKeyup(event) {
        const isESCKey = event.keyCode === 27 ? true : false;

        if (isESCKey) {
            this.closeModal(event);
        }
    }

    initPerfectScrollbar() {
        new PerfectScrollbar(this.elements.modalWindow, {
            wheelSpeed: 0.5,
            suppressScrollX: false,
            suppressScrollY: false,
        });
    }
}

("use script");
new OW_ModalWindow();
