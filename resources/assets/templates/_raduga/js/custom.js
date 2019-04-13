//MAGNIFIC POPUP
$(document).ready(function() {
    $('.images-block').magnificPopup({
        delegate: 'a', 
        type: 'image',
        gallery: {
        enabled: true
        }
    });
});

(function($) {

    "use strict";

    // TOOLTIP	
	$(".header-links .fa, .tool-tip").tooltip({
        placement: "bottom"
    });
    $(".btn-wishlist, .btn-compare, .display .fa").tooltip('hide');

    // Product Owl Carousel
    $(".owl-carousel").owlCarousel({
        autoPlay: false, //Set AutoPlay to 3 seconds
        items : 3,
        stopOnHover : true,
        navigation : true, // Show next and prev buttons
        pagination : false,
        navigationText : ["<span class='fa fa-chevron-left'></span>","<span class='fa fa-chevron-right'></span>"]
    });

    // TABS
    $('.nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });	
	
})(window.jQuery);

//Quantity Button
let quantity = {
    'buttons': {
        'increment' : document.getElementsByClassName('quantity_inc'),
        'decrement' : document.getElementsByClassName('quantity_dec'),
        'delete'    : document.getElementsByClassName('quantity_del'),
        'update'    : document.getElementsByClassName('quantity_upd')
    },
    'inputs'    : document.getElementsByClassName('quantity_input'),
    'form'      : document.getElementById('basket_form')
};

for(let buttonsType in quantity.buttons){

    if(quantity.buttons.hasOwnProperty(buttonsType)){

        for( let buttonIndex = 0; buttonIndex < quantity.buttons[buttonsType].length; buttonIndex++){

            switch(buttonsType){
                case 'increment':
                case 'decrement':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        e = e || event;
                        changeQuantity(e, buttonIndex)
                    });
                    break;
                case 'delete':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        quantity.inputs[buttonIndex].value = 0;
                        quantity.form.submit();
                    });
                    break;
                case 'update':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        //любая кнопка обновляет все товары
                        quantity.form.submit();
                    });
                    break;
            }

        }

    }

}

function changeQuantity(e, buttonIndex){

    let minValue = e.target.dataset.quantityMinValue;

    if ( e.target.classList.contains('quantity_inc')) {
        ++quantity.inputs[buttonIndex].value;
    } else if(e.target.classList.contains('quantity_dec')){
        if(quantity.inputs[buttonIndex].value > minValue)
            --quantity.inputs[buttonIndex].value;
    }
}
//END Quantity Button


/* PHOTO360 */
$('.open-popup-link').magnificPopup({
    type:'inline',
    midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
});
let photo360 = document.getElementById('photo360');

import Tridi from 'tridi/dist/js/tridi';

let tridi = new Tridi({
    element: '#photo360',
    location: photo360.getAttribute('data-location'),
    format: photo360.getAttribute('data-format'),
    count: photo360.getAttribute('data-count'),
});

tridi.load();

let prevBtn = document.querySelector('.custom-control-prev');
let nextBtn = document.querySelector('.custom-control-next');
let startBtn = document.querySelector('.custom-control-start');
let stopBtn = document.querySelector('.custom-control-stop');

// Click events

prevBtn.addEventListener('click', function() {
    tridi.prev();
});

nextBtn.addEventListener('click', function() {
    tridi.next();
});

startBtn.addEventListener('click', function() {
    tridi.autoplayStart();
});

stopBtn.addEventListener('click', function() {
    tridi.autoplayStop();
});

// Touch events

prevBtn.addEventListener('touchend', function() {
    tridi.prev();
}, { passive: true });

nextBtn.addEventListener('touchend', function() {
    tridi.next();
}, { passive: true });

startBtn.addEventListener('touchend', function() {
    tridi.autoplayStart();
}, { passive: true });

stopBtn.addEventListener('touchend', function() {
    tridi.autoplayStop();
}, { passive: true });
/*END PHOTO360*/

