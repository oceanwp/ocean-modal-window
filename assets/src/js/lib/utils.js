export const slideUp = (element, duration = 300) => {
    element.style.boxSizing = "border-box";
    element.style.transitionProperty = "height, margin, padding";
    element.style.transitionDuration = `${duration}ms`;
    element.style.height = `${element.offsetHeight}px`;
    element.style.paddingTop = 0;
    element.style.paddingBottom = 0;
    element.style.marginTop = 0;
    element.style.marginBottom = 0;
    element.style.overflow = "hidden";

    setTimeout(() => {
        element.style.height = 0;
    }, 10);

    window.setTimeout(() => {
        element.style.display = "none";
        element.style.removeProperty("height");
        element.style.removeProperty("padding-top");
        element.style.removeProperty("padding-bottom");
        element.style.removeProperty("margin-top");
        element.style.removeProperty("margin-bottom");
        element.style.removeProperty("overflow");
        element.style.removeProperty("transition-duration");
        element.style.removeProperty("transition-property");
    }, duration);
};

export const slideDown = (element, duration = 300) => {
    element.style.removeProperty("display");

    let display = window.getComputedStyle(element).display;

    if (display === "none") {
        display = "block";
    }

    element.style.display = display;

    let height = element.offsetHeight;
    let paddingTop = window.getComputedStyle(element).paddingTop;
    let paddingBottom = window.getComputedStyle(element).paddingBottom;
    let marginTop = window.getComputedStyle(element).marginTop;
    let marginBottom = window.getComputedStyle(element).marginBottom;

    element.style.height = 0;
    element.style.paddingTop = 0;
    element.style.paddingBottom = 0;
    element.style.marginTop = 0;
    element.style.marginBottom = 0;
    element.style.overflow = "hidden";

    element.style.boxSizing = "border-box";
    element.style.transitionProperty = "height";
    element.style.transitionDuration = `${duration}ms`;

    setTimeout(() => {
        element.style.height = `${height}px`;
        if (paddingTop !== "0px" || paddingBottom !== "0px") {
            element.style.transitionProperty = "padding";
            element.style.transitionDuration = `${duration / 1.2}ms`;
            element.style.paddingTop = paddingTop;
            element.style.paddingBottom = paddingBottom;
            element.style.marginTop = marginTop;
            element.style.marginBottom = marginBottom;
        }
    }, 10);

    window.setTimeout(() => {
        element.style.removeProperty("height");
        element.style.removeProperty("overflow");
        element.style.removeProperty("transition-duration");
        element.style.removeProperty("transition-property");
        element.style.removeProperty("padding-top");
        element.style.removeProperty("padding-bottom");
        element.style.removeProperty("margin-top");
        element.style.removeProperty("margin-bottom");
    }, duration);
};
export const fadeIn = (element, _options = {}) => {
    const options = {
        opacity: 1,
        speed: "normal",
        display: null,
        callback: null,
    };

    Object.assign(options, _options);

    element.style.opacity = 0;
    element.style.display = !!options.display || "block";

    const fade = () => {
        let opacity = parseFloat(element.style.opacity);

        if ((opacity += options.speed === "fast" ? 0.2 : 0.1) <= options.opacity) {
            element.style.opacity = opacity;

            if (opacity === 1 && options.callback) {
                callback();
            }

            window.requestAnimationFrame(fade);
        }
    };

    window.requestAnimationFrame(fade);
};

export const fadeOut = (element, speed = "normal", display, callback = null) => {
    element.style.opacity = 1;
    element.style.display = display || "block";

    const fade = () => {
        let opacity = parseFloat(element.style.opacity);

        if ((opacity -= speed === "fast" ? 0.2 : 0.1) < 0) {
            element.style.display = "none";
        } else {
            element.style.opacity = opacity;

            if (opacity === 0 && callback) {
                callback();
            }

            window.requestAnimationFrame(fade);
        }
    };

    window.requestAnimationFrame(fade);
};
