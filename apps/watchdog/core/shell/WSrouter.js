
// const { coreMySQL } = require(coreApps + 'mysql.js');
// const { coreRedis } = require('/var/www/apps/api/apps/core/redis.js');
// const { client_token } = require('/var/www/apps/api/apps/watchdog/core/client_token.js');
// const test = require('WSscript_test')


class WSrouter {

    static router(request, connection) {

        var protocol = request.protocol;

        var __raw_route = (request.resource)
        var route = __raw_route.split('/');

        var point = route[1];
        var params = route[2];

        var result = null;

    }

    static test_launch(request, connection) {
        const axios = require('axios')

        connection.on('message', function (message) {

            var message_json;

            if (message.type === 'utf8') {

                message_json = JSON.parse(message.utf8Data);
            }

            var sessionToken = client_token.get_server_token(message_json.sessionToken, request);

            var config = {
                headers: {
                    sessionToken: sessiontoken,
                    AUTHTOKEN: 'eyJhcHBfbmFtZSI6IldhdGNoRG9nIiwiYXBwX3VzZXIiOiJtYXN0ZXJAZmVlZC53ZCIsImFwcF9pZCI6IldEIn0=',
                    INTERNALVIRTUALHOST: '127.0.0.2',
                }
            }

            axios
                .post('http://neocortex.api/test/launch', {}, config)
                .then(res => {
                    console.log(`statusCode: ${res.status}`)
                    console.log(res)
                })
                .catch(error => {
                    console.error(error)
                })
        });

        connection.on('close', function (reasonCode, description) {
            console.log((new Date()) + ' Peer ' + connection.remoteAddress + ' disconnected.');
        });


    }



}

exports.WSrouter = WSrouter;
