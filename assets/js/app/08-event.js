$(function () {
    // On initialise la latitude et la longitude de Paris (centre de la carte)
    var latPc = 15.79838442183962;
    var lonPc = 4.318341874999987;
    var latMobile = 48.852969;
    var lonMobile = 2.349903;
    var map = null;
    // récupère le type de devices
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
    // if (eventX && eventY) {
    //     //faire un ajax pour aller prendre la liste des équipements lier au lieu.
    //     if (map != null) {
    //         map.remove();
    //     }
    //     if (isMobile.any()) {
    //         map = L.map('map').setView([eventY, eventX], 16);
    //     } else {
    //         map = L.map('map').setView([eventY, eventX], 16);
    //     }
    //     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    //     }).addTo(map);
    //     L.marker([eventY, eventX]).addTo(map)
    //         .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
    //         .on(
    //             'mouseover',
    //             function (e) {
    //                 this.openPopup();
    //             }
    //         )
    //         .on(
    //             'mouseout',
    //             function () {
    //                 this.closePopup();
    //             }
    //         );
    //     // deactivate wheelZoom
    //     map.scrollWheelZoom.disable();
    // }
    // if (eventPlaceId) {
    //     $('#sm_event_eventsPlace').val(eventPlaceId);
    // }
    // $('#sm_event_place').autocomplete({
    //     source: function (requete, reponse) { // les deux arguments représentent les données nécessaires au plugin
    //         $.ajax({
    //             url: Routing.generate('front_event_places'), // on appelle le script JSON
    //             method: "POST",
    //             dataType: 'json', // on spécifie bien que le type de données est en JSON
    //             data: {
    //                 search: $('#sm_event_place').val()
    //             },
    //             success: function (data) {
    //                 reponse(data);
    //             }
    //         });
    //     },
    //     minLength: 4,
    //     maxShowItems: 5, // Make list height fit to 5 items when items are over 5.
    //     select: function (event, ui) { // lors de la sélection d'une proposition
    //         //faire un ajax pour aller prendre la liste des équipements lier au lieu.
    //         if (map != null) {
    //             map.remove();
    //         }
    //         if (isMobile.any()) {
    //             map = L.map('map').setView([ui.item.gpsY, ui.item.gpsX], 16);
    //         } else {
    //             map = L.map('map').setView([ui.item.gpsY, ui.item.gpsX], 16);
    //         }
    //         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //             attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    //         }).addTo(map);
    //         if (ui.item.gpsX && ui.item.gpsY) {
    //             L.marker([ui.item.gpsY, ui.item.gpsX]).addTo(map)
    //                 .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
    //                 .on(
    //                     'mouseover',
    //                     function (e) {
    //                         this.openPopup();
    //                     }
    //                 )
    //                 .on(
    //                     'mouseout',
    //                     function () {
    //                         this.closePopup();
    //                     }
    //                 );
    //         }
    //         // mets à jour les champs d'information sur les équipements et le détails des installations
    //         $('#eventName').html(ui.item.nomInstallation);
    //         $('#eventAdresse').html(ui.item.adresse);
    //         $('#eventCodePostal').html(ui.item.codePostal);
    //         $('#eventVille').html(ui.item.ville);
    //         $('#sm_event_eventsPlace').val(ui.item.id);
    //         // deactivate wheelZoom
    //         map.scrollWheelZoom.disable();
    //     }
    // });
});
