/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
const $ = require('jquery');


// create global $ and jQuery variables
 global.$ = global.jQuery = $;

require('bootstrap');

import 'select2';


let input_select2 = $('.js-select2');
input_select2.select2({
    allowClear: true,
    placeholder: input_select2.attr('placeholder'),

});

