// import 'brunch';
// import 'jquery-confirm';
// import 'bootstrap-select/dist/css/bootstrap-select.css';
// import 'bootstrap-select';
// import 'dropzone/dist/min/dropzone.min.css';
// import '@fortawesome/fontawesome-free/css/all.min.css';
// import '@fortawesome/fontawesome-free/js/all.js';
// import 'flatpickr/dist/flatpickr.min.css';
// import jodit from "jodit/build/jodit.min.js";
// import 'jodit/build/jodit.min.css';
// import 'jquery-ui-bundle/jquery-ui.css';
// import 'jquery-ui-bundle/jquery-ui';
// window.flatpickr = require('flatpickr');
// window.Jodit = jodit;
// import { French } from "flatpickr/dist/l10n/fr";
//
// import '../css/app.scss';

$(function () {
   /**
    * Change locale
    */
   let $locale = $('#locale');
   $locale.change(function () {
      document.location.href = $locale.find(':selected').data('target');
   });

});
