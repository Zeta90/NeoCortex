const WebSocketServer = require('websocket').server;
const http = require('http');

module.exports = {

    createNewWSServer: function () {
        var server = http.createServer(function (request, response) {
            console.log((new Date()) + ' Received request for ' + request.url);

            response.writeHead(200);
            response.end();
        });

        // create the server
        server.listen(8000, function () {
            console.log((new Date()) + ' Server is listening on port 8080');
        });

        var wsServer = new WebSocketServer({
            httpServer: server,
            // You should not use autoAcceptConnections for production
            // applications, as it defeats all standard cross-origin protection
            // facilities built into the protocol and the browser.  You should
            // *always* verify the connection's origin and decide whether or not
            // to accept it.
            // autoAcceptConnections: true
        });

        return new Promise(resolve => {
            resolve(wsServer);
        });
    },


    processRoute: function () {
        const fs = require('fs');
        var rawdata = fs.readFileSync('/var/www/apps/api/core/cfg/routes.json');
        var routes = JSON.parse(rawdata, true);

        var route = null;
        var routes_filtered = [];

        for (route in routes) {
            if (routes[route].WD_trazable === true) {
                var fncts = null;
                routes_filtered[route] = [];
                for (fncts in routes[route].get_functions) {
                    console.log(routes[route].get_functions[fncts])
                    if (routes[route].get_functions[fncts].WD_function === true) {
                        routes_filtered[route][fncts] = routes[route].get_functions[fncts];
                    }
                };
            }
        };

        return routes_filtered;
    },

    startRequestProcessing: function (server) {
        server.on('request', async function (request) {
            // if (!originIsAllowed(request.origin)) {
            //   // Make sure we only accept requests from an allowed origin
            //   request.reject();
            //   console.log((new Date()) + ' Connection from origin ' + request.origin + ' rejected.');
            //   return;
            // }
            var sessiontoken = '';
            var connection = request.accept('ws', request.origin);

            var route_splitted = request.resource.split('/');
            route_splitted.shift();

            if (route_splitted[2].includes(':')) {
                var params = route_splitted[2].split(';');

                var final_params = [];

                params.forEach(param => {
                    var final_param = param.split(':');

                    if (final_param[0] === 'sessiontoken') {
                        var public_sessiontoken = final_param[1].split('@');
                        var sessiontoken_data = public_sessiontoken[0].split('-');
                        sessiontoken = sessiontoken_data[0] + sessiontoken_data[2];
                        final_params[final_param[0]] = sessiontoken;
                    } else {
                        final_params[final_param[0]] = final_param[1];
                    }
                });

            }

            const Streaming = require('../controller/streaming.js');
            var streaming = await Streaming[route_splitted[1]](final_params);
            routes = 1


            console.log((new Date()) + ' Connection accepted.');
            // connection.on('message', function (message) {
            //     if (message.type === 'utf8') {
            //         console.log('Received Message: ' + message.utf8Data);
            //         connection.sendUTF(message.utf8Data);
            //     }
            //     else if (message.type === 'binary') {
            //         console.log('Received Binary Message of ' + message.binaryData.length + ' bytes');
            //         connection.sendBytes(message.binaryData);
            //     }
            // });
            // connection.on('close', function (reasonCode, description) {
            //     console.log((new Date()) + ' Peer ' + connection.remoteAddress + ' disconnected.');
            // });
        });
    }
}

