$(function () {
    var $calendar = $('#calendar');

    $calendar.fullCalendar({
        header: {
            left: 'prev,next today',
            center: '',
            right: ''
        },
        now: now,

        defaultView: 'agendaWeek',
        slotLabelFormat:"HH:mm",
        slotDuration: '00:30:00',
        minTime: "06:00:00",
        timeFormat: "H:mm",
        allDaySlot: false,
        selectable: true,
        selectHelper: true,
        eventStartEditable: false,
        eventLimit: true, // allow "more" link when too many events
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv', 'Févr', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        buttonText: {
            today:    'aujourd\'hui',
            month:    'mois',
            week:     'semaine',
            day:      'jour',
            list:     'liste'
        },
        views: {
            month: {
                titleFormat: "MMMM YYYY"
            },
            week: {
                columnFormat: "dddd DD/MM/Y"
            },
            day: {
                columnFormat: "dddd D"
            }
        },
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: Routing.generate('front_load_calendar'),
                data: {
                    start: start.toISOString(),
                    end: end.toISOString()
                },
                method: 'post',
                success: function(data) {
                    callback(data.events);
                }
            })
        },
        eventClick: function(calEvent, jsEvent, view) {
            window.location.href = calEvent.edit_path;
        },
        timezone: 'local',
    });

    /**
     * Convert la date
     * @param date
     * @returns {string}
     */
    function dateToString(date)
    {
        var month = date.getMonth() + 1;
        var day = date.getDate();

        if (month <= 9) {
            month = '0' + month;
        }

        if (day <= 9) {
            day = '0' + day;
        }

        return date.getFullYear() + '-' + month + '-' + day;
    }
});


