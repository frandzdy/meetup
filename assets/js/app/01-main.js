// import 'socketio';
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
// import swal from 'sweetalert';
var latPc = 15.79838442183962;
var lonPc = 4.318341874999987;
var latMobile = 48.852969;
var lonMobile = 2.349903;

var isMobile = {
   Android: function () {
      return navigator.userAgent.match(/Android/i);
   },
   BlackBerry: function () {
      return navigator.userAgent.match(/BlackBerry/i);
   },
   iOS: function () {
      return navigator.userAgent.match(/iPhone|iPad|iPod/i);
   },
   Opera: function () {
      return navigator.userAgent.match(/Opera Mini/i);
   },
   Windows: function () {
      return navigator.userAgent.match(/IEMobile/i);
   },
   any: function () {
      return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
   }
};
$(function () {
   /**
    * Change locale
    */
   let $locale = $('#locale');
   $locale.change(function () {
      document.location.href = $locale.find(':selected').data('target');
   });

   $('input[type="file"]').change(function(e){
      var fileName = e.target.files[0].name;

      $(this).next().html(fileName);
   });

});
