class OW_Base {
    #settings;
    elements;

    constructor() {
        this.onInit();
        this.bindEvents();
    }

    getDefaultSettings() {
        return {};
    }

    getDefaultElements() {
        return {};
    }

    onInit() {
        this.#settings = this.getDefaultSettings();
        this.elements = this.getDefaultElements();
    }

    bindEvents() {}

    getSettings(key = null) {
        if (!!key) {
            return this.#settings[key];
        }

        return this.#settings;
    }

    setSettings(settings = {}) {
        if (!settings) {
            return;
        }

        this.#settings = Object.assign(this.#settings, settings);
    }
}

export default OW_Base;
