/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

// var api = wp.customize;

// api('omw_background_image', function(value) {
//     value.bind(function(to) {
//         var child = document.querySelector('.customizer-omw_background_image');
//         if (to) {
//             var style = document.createElement('style');
//             style.className = 'customizer-omw_background_image';
//             style.innerHTML = '.omw-modal{background-image: url(' + oceanModalWindow.bgImage + '); background-position: center center; background-repeat: no-repeat; background-size: cover;}';

//             if (child) {
//                 child.replaceWith(style);
//             } else {
//                 document.head.appendChild(style);
//             }
//         } else if (child) {
//             child.remove();
//         }
//     });
// });


var api = wp.customize;

api('omw_background_image', function(value) {
    value.bind(function(to) {
        var child = document.querySelector('.customizer-omw_background_image');

        if (to) {
            // Fetch the URL if 'to' is an image ID
            fetchImageUrl(to).then(function(imageUrl) {
                if (imageUrl) {
                    var style = document.createElement('style');
                    style.className = 'customizer-omw_background_image';
                    style.innerHTML = '.omw-modal{background-image: url(' + imageUrl + '); background-position: center center; background-repeat: no-repeat; background-size: cover;}';

                    if (child) {
                        child.replaceWith(style);
                    } else {
                        document.head.appendChild(style);
                    }
                }
            });
        } else {
            // Handle the case where the image is removed
            if (child) {
                child.remove();
            }

            // Remove the background image
            var style = document.createElement('style');
            style.className = 'customizer-omw_background_image';
            style.innerHTML = '.omw-modal{background-image: none;}';
            document.head.appendChild(style);
        }
    });
});

// Function to fetch image URL from ID using WordPress REST API
function fetchImageUrl(imageId) {
    return fetch('/wp-json/wp/v2/media/' + imageId)
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(function(data) {
            return data.source_url;
        })
        .catch(function(error) {
            console.error('There was a problem with the fetch operation:', error);
            return null;
        });
}
