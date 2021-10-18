#!/usr/bin/env node

var WebSocketServer = require('websocket').server;
var http = require('http');
const axios = require('axios')

class WSScontroller {

    constructor(wsServer) {
        this.attend_WSServer_request(wsServer);
    }

    attend_WSServer_request(wsServer) {
        // create the server

        var a;
        var d;

        var connection;

        wsServer.on('request', function (request) {
            connection = request.accept(null, request.origin);
            this.execute_incoming_command(connection);
            
            // This is the most important callback for us, we'll handle
            // all messages from users here.
            // var command;
            // var args;


            // connection.on('message', function (in_message) {
            //     command = request['resource'];
            //     args = in_message;

            //     // WSScontroller.execute_incoming_command(request['resource'], message);
            //     connection.send('1');
            //     if (message.type === 'utf8') {
            //         // process WebSocket message
            //     }
            // });

            // // this.execute_incoming_command(command, args);

            // connection.on('close', function (connection) {
            //     // close user connection
            // });

        })
        return connection;
    }

    execute_incoming_command(connection) {
        if (connection === 'NeoCortexTest') {
            // Will serve a redis bucket in LIVE and will run the test through PHP

            this.HTTP_POST_Request();
        }
    }

    serve_redis_bucket_in_loop() {

    }

    HTTP_POST_Request(point) {
        axios
            .post('https://neocortex.api/' + point, {
                todo: 'Buy the milk'
            })
            .then(res => {
                console.log(`statusCode: ${res.status}`)
                console.log(res)
            })
            .catch(error => {
                console.error(error)
            })
    }
}

exports.WSScontroller = WSScontroller;