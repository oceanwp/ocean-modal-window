export const slideDown = (element, duration = 300) => {
    let display = window.getComputedStyle(element).display;

    if (display === "none") {
        display = "block";
    }

    element.style.transitionProperty = "height";
    element.style.transitionDuration = `${duration}ms`;

    element.style.opacity = 0;
    element.style.display = display;
    let height = element.offsetHeight;

    element.style.height = 0;
    element.style.opacity = 1;
    element.style.overflow = "hidden";

    setTimeout(() => {
        element.style.height = `${height}px`;
    }, 5);

    window.setTimeout(() => {
        element.style.removeProperty("height");
        element.style.removeProperty("overflow");
        element.style.removeProperty("transition-duration");
        element.style.removeProperty("transition-property");
        element.style.removeProperty("opacity");
    }, duration + 50);
};

export const slideUp = (element, duration = 300) => {
    element.style.boxSizing = "border-box";
    element.style.transitionProperty = "height, margin";
    element.style.transitionDuration = `${duration}ms`;
    element.style.height = `${element.offsetHeight}px`;
    element.style.marginTop = 0;
    element.style.marginBottom = 0;
    element.style.overflow = "hidden";

    setTimeout(() => {
        element.style.height = 0;
    }, 5);

    window.setTimeout(() => {
        element.style.display = "none";
        element.style.removeProperty("height");
        element.style.removeProperty("margin-top");
        element.style.removeProperty("margin-bottom");
        element.style.removeProperty("overflow");
        element.style.removeProperty("transition-duration");
        element.style.removeProperty("transition-property");
    }, duration + 50);
};

export const slideToggle = (element, duration) => {
    window.getComputedStyle(element).display === "none" ? slideDown(element, duration) : slideUp(element, duration);
};

export const fadeIn = (element, _options = {}) => {
    const options = {
        duration: 300,
        display: null,
        opacity: 1,
        callback: null,
    };

    Object.assign(options, _options);

    element.style.opacity = 0;
    element.style.display = options.display || "block";

    setTimeout(() => {
        element.style.transition = `${options.duration}ms opacity ease`;
        element.style.opacity = options.opacity;
    }, 5);

    setTimeout(() => {
        element.style.removeProperty("transition");
        !!options.callback && options.callback();
    }, options.duration + 50);
};

export const fadeOut = (element, _options = {}) => {
    const options = {
        duration: 300,
        display: null,
        opacity: 0,
        callback: null,
    };

    Object.assign(options, _options);

    element.style.opacity = 1;
    element.style.display = options.display || "block";

    setTimeout(() => {
        element.style.transition = `${options.duration}ms opacity ease`;
        element.style.opacity = options.opacity;
    }, 5);

    setTimeout(() => {
        element.style.display = "none";
        element.style.removeProperty("transition");
        !!options.callback && options.callback();
    }, options.duration + 50);
};

export const fadeToggle = (element, options) => {
    window.getComputedStyle(element).display === "none" ? fadeIn(element, options) : fadeOut(element, options);
};
