// Afficher un popin contenant iframe
window.createIframeModal = function (src, options, title) {
    alert('source' + src);
    var $modal = $($("#modal-prototype").html());
    alert('title ' + title);
    if (title) {
        $modal.find('.modal-title').html(title);
    }

    $modal.find('.modal-body').append('<iframe src="' + src + '" width="100%" height="800px" class="borderNone"></iframe>');

    $('#modals').append($modal);

    if (typeof options !== "undefined" && options !== null) {
        if (typeof options.width !== "undefined") {
            $modal.css({width: options.width});
        }

        if (typeof options.height !== "undefined") {
            $modal.css({height: options.height});
            $modal.find('.modal-body iframe').attr('height', options.height);
        }

        if (typeof options.top !== "undefined") {
            $modal.css({top: options.top});
        }

        if (typeof options.left !== "undefined") {
            $modal.css({left: options.left});
        }
    }

    $modal.modal({'backdrop': false});
    $modal.draggable();
    $modal.resizable({
        handles: "all",
        alsoResize: 'iframe'
    });
    $modal.on('hidden.bs.modal', function () {
        $modal.remove();
    });

    return $modal;
};

// Vérifier le téléphone existe
window.checkPhoneExist = function (check_path, excludeId, country) {
    $('.check-phone').click(function () {
        var type = 'mobile';
        if ($(this).hasClass('phone-fix')) {
            type = 'fix';
        }
        var $number = $(this).closest('div').find('input').val();

        // Si le pays = France, on verifié le numéro de téléphone avec le format 01.01.01.01.01
        if (country == 'France') {
            // Enlever espace, point, et vercule pour le numéro de téléphone
            $number = $number.replace(/\.|,|\s+/g, '');
            var numberArray = $number.split('');
            var newNumber = '';
            for (var i = 1; i <= numberArray.length; i ++) {
                if (i % 2 == 0 && i != numberArray.length) {
                    newNumber += numberArray[i - 1] + '.'
                } else {
                    newNumber += numberArray[i - 1];
                }
            }
            $number = newNumber;
        }

        var $errorDiv = $(this).closest('div').find('.errors-message');
        if ($number == '') {
            $errorDiv.removeClass('notice').addClass('errors');
            $errorDiv.html('<ul><li>Information requise.</li></ul>');
            return false;
        }
        $.ajax({
            url: Routing.generate(check_path),
            method: "GET",
            data: {
                'type': type,
                'number': $number,
                'excludeId': excludeId
            },
            success: function (data) {
                if (data.exist) {
                    $errorDiv.removeClass('notice').addClass('errors');
                    $errorDiv.html('<ul><li>Ce numéro de téléphone est déjà enregistré.</li></ul>');
                } else {
                    $errorDiv.removeClass('errors').addClass('notice');
                    $errorDiv.html('<ul><li>Ce numéro n\'est pas enregistré.</li></ul>');
                }
            }
        });
    });
};

window.myToast = function($title, $msg, $icon){
    $.toast({
        heading: $msg, // Optional heading to be shown on the toast
        text: $title, // Text that is to be shown in the toast
        icon: 'info',
        showHideTransition: 'slide', // fade, slide or plain
        allowToastClose: true, // Boolean value true or false
        hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
        stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
        position: 'top-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

        bgColor: '#07b480',  // Background color of the toast
        textColor: '#ffffff',  // Text color of the toast
        textAlign: 'left',  // Text alignment i.e. left, right or center
        loader: false,  // Whether to show loader or not. True by default
        loaderBg: '#59c694',  // Background color of the toast loader
        beforeShow: function () {}, // will be triggered before the toast is shown
        afterShown: function () {}, // will be triggered after the toat has been shown
        beforeHide: function () {}, // will be triggered before the toast gets hidden
        afterHidden: function () {}  // will be triggered after the toast has been hidden
    });

};

$(function () {
    // Datetimepicker bouton
    $('.datetimepicker-btn').on('click', function () {
        $(this).closest('.datetimepicker-container').find('input').datetimepicker('show');
    });

    $('[data-toggle="popover"]').popover({
        html: true
    });

    $(".datetimepicker").datetimepicker({
        format: 'd/m/Y H:i',
        lang: 'fr',
        dayOfWeekStart: 1,
        step: 5
    });

    $(".datepicker").datepicker();
    // Bootstrap Multiple modals
    $(document).on('click', '.add-multiple-modal', function (e) {
        e.preventDefault();
        if ($(this).attr('disabled')) {
            return false;
        }
        console.log($(this).data('path'));
        console.log($(this).data('title'));
        var width = $(this).data('width') || "800px";
        var height = $(this).data('height') || "800px";
        var top = $(this).data('top') || 0;
        var left = $(this).data('left') || '25%';
        var $modal = createIframeModal($(this).data('path'), {width: width, height: height, top: top, left: left}, $(this).data('title'));

        var modalClass = $(this).data('modal-class') || '';
        if (modalClass) {
            $modal.addClass(modalClass);
        }
    });

    $('select[disabled]').addClass('bo-gray');
    $('input[disabled]').addClass('bo-gray');
    $('textarea[disabled]').addClass('bo-gray');
    $('input[type="checkbox"][disabled]').parent('.expanded-element-container').find('label').addClass('bo-gray-checkbox color-gray-meduim');
    $('input[type="checkbox"][readonly]').on('click', function () {
        return false;
    });
    // auto complete event creation
});

