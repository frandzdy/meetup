$.fn.extend({
    addressRobotFr: function(options) {
        var settings = $.extend({
            country: null,
            postCode: null,
            city: null,
            roadNumber: null,
            roadName: null,
            active: true,
            cityShowLimit: 10,
            roadNameShowLimit: 10
        }, options);

        if (settings.country) {
            initFields(settings.postCode, settings.city, settings.roadName, settings.cityShowLimit, settings.roadNameShowLimit, settings.active);
        }

        if (settings.postCode && settings.city) {
            getCityByPostCode(settings.postCode, settings.city, settings.cityShowLimit, settings.active);
        }

        if (settings.postCode) {
            getRoadNameByPostcode(settings.postCode, settings.roadName, settings.roadNameShowLimit, settings.active);
        }
    }
});

/**
 * Initialise les champs
 *
 * @param postCode
 * @param city
 * @param roadName
 * @param cityShowLimit
 * @param addressShowLimit
 * @param active
 */
function initFields(postCode, city, roadName, cityShowLimit, addressShowLimit, active)
{
    if (!active) {
        emptyAutocomplete(city);
        emptyAutocomplete(roadName);
    } else {
        autocompleteCity(postCode, city, cityShowLimit, active);
        autocompleteRoadName(postCode, roadName, addressShowLimit, active);
    }
}

/**
 * Recherche les villes par code postal
 *
 * @param postCode
 * @param city
 * @param cityShowLimit
 * @param active
 */
function getCityByPostCode(postCode, city, cityShowLimit, active)
{
    postCode.on('keyup', function () {
        autocompleteCity(postCode, city, cityShowLimit, active);
    });
}

/**
 * Recherche l'adresse par code postal
 *
 * @param postCode
 * @param roadName
 * @param addressShowLimit
 * @param active
 */
function getRoadNameByPostcode(postCode, roadName, addressShowLimit, active)
{
    var postCodeId = postCode[0].id;
    var roadNameId = roadName[0].id;

    $('#' + postCodeId + ', #' + roadNameId).on('keyup', function() {
        autocompleteRoadName(postCode, roadName, addressShowLimit, active);
    });
}

/**
 * fonction autocomplete
 *
 * @param target
 * @param data
 * @param limit
 * @param active
 */
function autocomplete(target, data, limit, active)
{
    target.autocomplete({
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(data, request.term);
            response(results.slice(0, limit));
        },
        minLength : 0,
        disabled: !active
    }).focus(function () {
        $(this).autocomplete("search");
    });

    // Overrides the default autocomplete filter function to search only from the beginning of the string
    // $.ui.autocomplete.filter = function (array, term) {
    //     var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(term), "i");
    //     return $.grep(array, function (value) {
    //         return matcher.test(value.label || value.value || value);
    //     });
    // };
}

/**
 * Autocomplete ville
 *
 * @param postCode
 * @param city
 * @param cityShowLimit
 * @param active
 */
function autocompleteCity(postCode, city, cityShowLimit, active)
{
    if (postCode.val().length == 5) {
        var url = 'https://geo.api.gouv.fr/communes?codePostal=' + postCode.val();
        var cities = [];
        if (active) {
            $.get(url, function (data) {
                $.each(data, function(index, object) {
                    cities.push(object['nom']);
                });
            });
        }

        autocomplete(city, cities, cityShowLimit, active);
    }
}

/**
 * Autocomplete adresse
 *
 * @param postCode
 * @param roadName
 * @param addressShowLimit
 * @param active
 */
function autocompleteRoadName(postCode, roadName, addressShowLimit, active)
{
    var url = 'http://api-adresse.data.gouv.fr/search/?q=' + (roadName.val() ? roadName.val() : 'r') + '&postcode=' + postCode.val() + '&limit=' + addressShowLimit;
    var roadNames = [];
    if (active) {
        $.get(url, function (data) {
            $.each(data.features, function (index, object) {
                if ($.inArray(object.properties['name'], roadNames) == -1) {
                    roadNames.push(object.properties['name']);
                    roadNames.sort();
                }
            });
        });
    }

    autocomplete(roadName, roadNames, addressShowLimit, active);
}

/**
 * Autocomplete avec la liste vide
 * @param target
 */
function emptyAutocomplete(target) {
    target.autocomplete({
        source: '',
        minLength: 0
    })
}
