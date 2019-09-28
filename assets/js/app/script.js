// Confirmation de suppression
window.confirmDelete = function ($element) {
    $element
        .find('.confirm-delete')
        .each(function() {
            $(this).bootstrap_confirm_delete({
                heading: 'Confirmation',
                message: $(this).data('message') || 'Confirmez-vous la suppression ?',
                btn_ok_label: 'Oui',
                btn_cancel_label: 'Annuler',
                data_type: null
            });
        });
};


// datepicker
window.datepicker = function () {
    $("input.datepicker").each(function () {
        $(this).datepicker({
            changeMonth: true,
            changeYear: true,
            maxDate: ($(this).attr('max-date') === '' ? false : $(this).attr('max-date')),
            minDate: ($(this).attr('min-date') === '' ? false : $(this).attr('min-date')),
            yearRange: "-100:+5",
            closeText: 'Fermer',
            prevText: 'Précédent',
            nextText: 'Suivant',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            weekHeader: 'Sem.',
            firstDay: 1,
            dateFormat: "dd/mm/yy"
        });
    });

    // Datepicker bouton
    $('.datepicker-btn').on('click', function () {
        $(this).closest('.datepicker-container').find('input').datepicker('show');
    });
};


// Saisie une adresse
window.enterAddress = function (countryCode) {
    var $country = $('.adCountry');
    $country.on('change', function () {
        var active = false;
        if ($(this).val() == 'FR') {
            active = true;
            $('.phone_format').attr({'maxlength': 14, 'placeholder': '00.00.00.00.00'});
        } else {
            $('.phone_format').attr('maxlength', 32).removeAttr('placeholder');
        }

        $('div').addressRobotFr({
            country: $('.adCountry'),
            postCode: $('.adCodePostal'),
            city: $('.adVille'),
            roadNumber: $('.adNum'),
            roadName: $('.adRue'),
            active: active
        });
    });

    $country.trigger('change');
};

// Afficher un popin contenant iframe
window.createIframeModal = function (src, options, title) {
    var $modal = $($("#modal-prototype").html());
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
    $("#openCloseAsideBar").on("click", function () {
        var $element = $(".page .middle");
        if ($element.hasClass('reduceAsideBar')) {
            $element.removeClass('reduceAsideBar');
            Cookies.remove('aside-bar-reduced');
        } else {
            $element.addClass('reduceAsideBar');
            Cookies.set('aside-bar-reduced', 'true');
        }
    });

    confirmDelete($(document));
    $('[data-toggle=popover]').on("shown.bs.popover", function() {
        confirmDelete($('.popover'));
    });

    datepicker();

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
        dayOfWeekStart: 1
    });


    // Bootstrap Multiple modals
    $(document).on('click', '.add-multiple-modal', function (e) {
        e.preventDefault();
        if ($(this).attr('disabled')) {
            return false;
        }

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


    $(".chosen-select").chosen({no_results_text: "Aucune zone trouvée."});

    $('select[disabled]').addClass('bo-gray');
    $('input[disabled]').addClass('bo-gray');
    $('textarea[disabled]').addClass('bo-gray');
    $('input[type="checkbox"][disabled]').parent('.expanded-element-container').find('label').addClass('bo-gray-checkbox color-gray-meduim');
    $('input[type="checkbox"][readonly]').on('click', function () {
        return false;
    });
});
