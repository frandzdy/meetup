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

var isMobile = !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
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

   $('textarea').mentionsInput({
      source: Routing.generate('front_contact_ajax'),
      showAtCaret: true,
      suffix: ' '
   });

   const players = new Plyr('.video', {
      enabled: !/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent),
      controls: ['play-large', 'play', 'current-time', 'mute', 'volume', 'captions', 'airplay', 'fullscreen']
   });

   $('.post').click(function (e) {
      e.stopImmediatePropagation();
      e.preventDefault();
      var formTextArea = $('#sm_wall_message').mentionsInput('getValue');
      var formTextAreaSanitaze = $('#sm_wall_message').val();
      var token = $('#sm_wall__token').val();
      var formData = new FormData();
      formData.append("video", $("#sm_wall_video_file").prop("files")[0]);
      for (i = 0; i < $("#sm_wall_photo_file").prop("files").length; i++) {
         formData.append("photo[]", $("#sm_wall_photo_file").prop("files")[i]);
      }
      formData.append("message", formTextArea);
      formData.append("messageSanitaze", formTextAreaSanitaze);
      formData.append("token", token);
      $.ajax({
         url: Routing.generate("front_wall"),
         contentType: false,
         processData: false,
         type: 'post',
         data: formData,
         beforeSend: function() {
         },
         success: function (data) {
            $('fieldset').after($(data.view)).fadeIn("slow");
         },
         done: function () {
            $('#sm_wall_message').val('');
            new Plyr('.video', {
               enabled: !/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent),
               controls: ['play-large', 'play', 'current-time', 'mute', 'volume', 'captions', 'airplay', 'fullscreen']
            });
         }
      });
   });
   $('div#wrapper').on('click', '.commentaireToSend', function (e) {
      e.stopImmediatePropagation();
      e.preventDefault();
      var that = $(this).closest('form');
      var wallId = $(this).closest('form').find('input[type="hidden"]').val();
      var formTextArea = $(this).closest('form').find('textarea').mentionsInput('getValue');
      var formTextAreaSanitaze = $(this).closest('form').find('textarea').val();
      var token = $(this).closest('form').find('input[name="wall[token]"]').val();
      $.ajax({
         url: Routing.generate("front_wall_commentaire"),
         method: "POST",
         data: {'wall[id]': wallId, 'wall[commentaire]': formTextArea, 'wall[commentaireSanitaze]': formTextAreaSanitaze, 'wall[token]': token},
         beforeSend: function(){
            that.find('textarea').val('');
         },
         success: function (response) {
            if ($('#wall-no-comment'+wallId).prop('id') != undefined) {
               $('#wall-no-comment'+wallId).replaceWith($(response.view)).fadeIn("slow");
            } else {
               $('.wall-last'+wallId).after($(response.view)).fadeIn("slow");
               $('.wall-last'+wallId).eq(0).removeClass('wall-last'+wallId);
            }
         },
         done: function () {
            that.find('textarea').val('');
            new Plyr('.video', {
               enabled: !/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent),
               controls: ['play-large', 'play', 'current-time', 'mute', 'volume', 'captions', 'airplay', 'fullscreen']
            });
         }
      });
   });
   // Multiple images preview in browser
   var imagesPreview = function(input, placeToInsertImagePreview) {
      if (input.files) {
         var filesAmount = input.files.length;
         for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
               $($.parseHTML('<img>')).attr('src', event.target.result).addClass('image-commentaire rounded img-fluid img-thumbnail').appendTo(placeToInsertImagePreview);
            }
            reader.readAsDataURL(input.files[i]);
         }
      }
   };
   $('#sm_wall_photo_file').on('change', function() {
      $('div.gallery').fadeOut();
      $('div.gallery').html('');
      imagesPreview(this, 'div.gallery');
      $('div.gallery').fadeIn('slow');
   });

   $('div#wrapper').on('click', '.likeWall', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var el = $(this);
      $.ajax({
         url: Routing.generate('front_wall_like_wall'),
         type: 'post',
         dataType: 'json',
         data: {'wall': $(this).data('id')},
         beforeSend: function () {
         },
         success: function (data) {
            console.log(data.response)
            if (data.response) {
               $('#nbLikeWall'+el.data('id')).html(parseInt($('#nbLikeWall'+el.data('id')).html())+1);
            } else {
               $('#nbLikeWall'+el.data('id')).html(parseInt($('#nbLikeWall'+el.data('id')).html())-1);
            }
            el.toggleClass("active");
         },
         error: function () {
         }
      });
   });
   $('div#wrapper').on('click', '.likeCommentaire', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var el = $(this);
      $.ajax({
         url: Routing.generate('front_wall_like_commentaire'),
         type: 'post',
         dataType: 'json',
         data:{'commentaire': $(this).data('id')},
         beforeSend: function () {
         },
         success: function (data) {
            if (data.response) {
               $('#nbLikeCommentaire'+el.data('id')).html(parseInt($('#nbLikeCommentaire'+el.data('id')).html())+1);
            } else {
               $('#nbLikeCommentaire'+el.data('id')).html(parseInt($('#nbLikeCommentaire'+el.data('id')).html())-1);
            }
            el.toggleClass("active");
         },
         error: function () {
         }
      });
   });
});
