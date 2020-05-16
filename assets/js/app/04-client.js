var limit = 5;
var step = 0;
var receive = 0;
var load = false;

$(function () {
    var socket = io.connect('http://tennis-meetup.fr:1337');
    console.log(socket);
    /**
     * on se connecte
     */
    socket.emit('login', {
        userId: userId
    });
    /**
     * message recu
     */
    socket.on('message', function (data) {
        if (data.groupId == $('#groupeId').val()) {
            addTemplate(data);
            $('#receiver').animate({scrollTop: $('#receiver').prop('scrollHeight')}, 500);
        } else {
            $("#badgeNotif").html(parseInt($("#badgeNotif").html()) + 1);
            // il faut dire a socket de mettre à jour la base en marquant le message comme non lue
        }
    });
    /**
     * Envoie Message
     */
    $('#FormMessenger').submit(function (event) {
        event.preventDefault();
        var message = $('#message').val();
        var to = $('#receiverId').val();
        var groupe = $('#groupeId').val();

        $.ajax({
            url: Routing.generate('front_chat_save_message',
                {
                    'discussion': groupe,
                    'token_id': userId
                }
            ),
            data: {
                message: message
            },
            method: "POST",
            beforeSend: function () {
                $('#message').val('');
            },
            success: function (data) {
                socket.emit('message', data.resultat);
                console.log(data.resultat);
            }
        });
    });
    /**
     * Liste d'amis
     */
    $('.friendLists').on('click', function () {
        load = true;
        step = 0;
        var selectedId = $(this).prop('id');
        if (selectedId != $('#groupeId').val()) {
            $('#receiverId').val(selectedId);
            $.ajax({
                url: Routing.generate('front_load_message'),
                data: {
                    groupe: selectedId,
                },
                method: "POST",
                beforeSend: function () {
                    $('#receiver').html('');
                    loader()
                },
                success: function (data) {
                    for (var k in data.resultat) {
                        addTemplate(data.resultat[k]);
                    }
                    $('#receiver').animate({scrollTop: $('#receiver').prop('scrollHeight')}, 500);
                    $('#groupeId').val(data.groupeId);
                    // il faut dire au scoket de mettre à jour tous les messages non en lu
                }, complete: function () {
                    removeLoader();
                    load = false;
                }
            })
        }
    });

    $('.groupeLists').on('click', function () {
        load = true;
        step = 0;
        var selectedId = $(this).prop('id');
        if (selectedId != $('#groupeId').val()) {
            $('#groupeId').val(selectedId);
            $('#receiver').val();
            $.ajax({
                url: Routing.generate('front_load_message'),
                data: {
                    groupe: selectedId,
                },
                method: "POST",
                beforeSend: function () {
                    $('#receiver').html('');
                    loader()
                },
                success: function (data) {
                    for (var k in data.resultat) {
                        addTemplate(data.resultat[k]);
                    }
                    $('#receiver').animate({scrollTop: $('#receiver').prop('scrollHeight')}, 500);
                    $('#groupeId').val(data.groupeId);
                }, complete: function () {
                    removeLoader()
                    load = false;
                }
            })
        }
    });

    $('#receiver').scroll(function () {
        if ($(this).scrollTop() == 0 && load == false) {
            var lastChat = $('#groupeId').val();
            step += limit;
            if (!receive) {
                $.ajax({
                    url: Routing.generate('front_load_message'),
                    data: {
                        groupe: $('#groupeId').val(),
                        step: step
                    },
                    method: "POST",
                    beforeSend: function () {
                        receive = true;
                        loader();
                    },
                    success: function (data) {
                        for (var k in data.resultat) {
                            addTemplate(data.resultat[k], 1);
                        }
                        $('#groupeId').val(data.groupeId);
                        receive = false;
                    },
                    complete: function(){
                        receive = false;
                        removeLoader();
                    }
                });
            }
        }
    });

    /**
     *
     * @param data
     */
    function addTemplate(data, append) {
        console.log(data);
        if(!append) {
            if (data.token != userId) {
                // pas mon message
                $('#receiver').append('<div class="container-chat darker" id="' + data.id + '"><img src="https://gravatar.com/avatar/' + data.token + '?s=20" alt="' + data.alt + '" class="left" style="width:100px"><p>' + data.message + '</p><span class="time-left">' + data.created_at + '</span></div>');
            } else {
                // mon message
                $('#receiver').append('<div class="container-chat " id="' + data.id + '"><img src="https://gravatar.com/avatar/' + data.token + '?s=20" alt="' + data.alt + '" class="right" style="width:100px"><p>' + data.message + '</p><span class="time-right">' + data.created_at + '</span></div>');
            }
        } else {
            if (data.token != userId) {
                // pas mon message
                $('#receiver').prepend('<div class="container-chat darker" id="' + data.id + '"><img src="https://gravatar.com/avatar/' + data.token + '?s=20" alt="' + data.alt + '" class="left" style="width:100px"><p>' + data.message + '</p><span class="time-left">' + data.created_at + '</span></div>');
            } else {
                // mon message
                $('#receiver').prepend('<div class="container-chat " id="' + data.id + '"><img src="https://gravatar.com/avatar/' + data.token + '?s=20" alt="' + data.alt + '" class="right" style="width:100px"><p>' + data.message + '</p><span class="time-right">' + data.created_at + '</span></div>');
            }
        }

    }

    /**
     * retourne le loader
     * @returns {string}
     */
    function loader() {

        return $("#receiver").prepend('<span class="loader"><img class="loaderImg" src="../../images/straight-loader.gif" alt="loarder"></span>');
    }

    /**
     * destroy loader
     * @returns {string}
     */
    function removeLoader() {

        $('.loader').remove();
    }
})
;
