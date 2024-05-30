/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

var api = wp.customize;

api('omw_background_image', function(value) {
    value.bind(function(to) {
        var child = document.querySelector('.customizer-omw_background_image');
        if (to) {
            var style = document.createElement('style');
            style.className = 'customizer-omw_background_image';
            style.innerHTML = '.omw-modal{background-image: url(' + to + '); background-position: center center; background-repeat: no-repeat; background-size: cover;}';

            if (child) {
                child.replaceWith(style);
            } else {
                document.head.appendChild(style);
            }
        } else if (child) {
            child.remove();
        }
    });
});
