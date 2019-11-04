var http = require('http');
var md5 = require('md5');
var mysql = require('mysql');
var mysql = require('mysql');
/**
 *  Création Serveur
 */
var httpServer = http.createServer(function (req, res) {
    res.end('Un nouvelle Utilisateur');
});
/**
 * Ecoute du port 1337
 */
httpServer.listen(1337);
/**
 *  Socket protocol hhtp
 */
var io = require('socket.io').listen(httpServer);
/**
 *
 */
var connexion = mysql.createConnection(
    {
        host: '192.168.1.30',
        user: 'root',
        password: 'toto44',
        database: 'sports'
    }
);

connexion.connect(function (err) {
    if (err) {
        console.log('Error connexion' + err);
    }
});
/**
 *
 * @type {{}}
 */
var connectedUsers = {};
var messages = [];
var me = {};
var limit = 5;
var step = 5;
var max = 0;
var offset = 0;

io.sockets.on('connection', function (socket) {
    /**
     * quand on est loggé
     */
    socket.on('login', function (data) {
        connexion.query('SELECT * FROM sm_user WHERE sm_user.token = ?', [data.userId], function (err, rows, fields) {
            if (err) {
                console.error(err);
                return false;
            }

            if (rows.length !== 0) {
                console.log('Log Utilisateur trouvé ' + rows[0]);
                me = {
                    id: rows[0].token,
                    lastname: rows[0].lastname,
                    firstname: rows[0].firstname,
                    token: rows[0].token,
                    avatar: "https://gravatar.com/avatar/" + md5(rows[0].email) + "?s=50"
                };
                console.log(me);
                console.log(socket.id);
                socket.username = me.token;
                connectedUsers[me.token] = socket.id;
                console.log('All users :');
                console.log(connectedUsers);
            } else {
                console.error('aucun utilisateur trouvé');
            }
        });
    });

    socket.on('scroll', function (data) {
        /**
         * pour chaque personne du groupe on le notifie
         */
        // calcul du nombre de résultat et du nombre de page à montrer
        connexion.query('SELECT * FROM sm_discussion sd ' +
            'join sm_message sm on sd.id = sm.discussion_id ' +
            'join sm_user su on sm.sender_id = su.id ' +
            'join sm_discussion_user sdu on sd.id = sdu.discussion_id AND su.id = sdu.user_id ' +
            'WHERE sd.token = ?',
            [
                data.groupId
            ], function (err, rows, fields) {
                if (err) {
                    console.error(err);
                    return false;
                }

                if (rows.length !== 0) {
                    step += limit;
                    max = rows.length;
                    offset = max - step;

                    console.log('nb' + max);
                    console.log('step : ' + step);
                    console.log('offset : ' + offset);
                } else {
                    console.error('aucune message trouvé');
                }
            });
        connexion.query('SELECT sd.token, sm.message, sm.create_at, sdu.user_id FROM sm_discussion sd ' +
            'join sm_message sm on sd.id = sm.discussion_id ' +
            'join sm_user su on sm.sender_id = su.id ' +
            'join sm_discussion_user sdu on sd.id = sdu.discussion_id AND su.id = sdu.user_id ' +
            'WHERE sd.token = ?' +
            'LIMIT ? ' +
            'OFFSET ?',
            [
                data.groupId,
                limit,
                offset
            ], function (err, rows, fields) {
                if (err) {
                    console.error(err);
                    return false;
                }

                if (rows.length !== 0) {
                    console.error('Message trouvé off' );
                    console.log(rows[0]);
                    // for (var k in data.groupUsers) {
                    //     io.to(connectedUsers[data.groupUsers[k]]).emit(
                    //         'message', data
                    //     );
                    //     console.log('Message to send' + data.groupUsers[k]);
                    // }
                } else {
                    console.error('aucune message trouvé');
                }
            });
    });

    socket.on('message', function (data) {
        /**
         * pour chaque personne du groupe on le notifie
         */
        for (var k in data.groupUsers) {
            io.to(connectedUsers[data.groupUsers[k]]).emit(
                'message', data
            );
            console.log('Message to send ' + data.groupUsers[k]);
        }
    });

    /**
     * Déconnexion
     */
    socket.on('disconnect', function (data) {
        console.log('Disconnecte');
        if (!me.id) {
            return false;
        }
    });
});
