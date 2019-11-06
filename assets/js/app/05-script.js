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

