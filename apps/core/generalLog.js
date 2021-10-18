// const { Request } = require(__dirname + '/request.js');
const path = require('path');

class generalLog {

    static get_file_route() {
        return path.join(__dirname, '../_control/watchdog/')
    }

    static feed_log(logFile, message) {
        var fs = require('fs');

        var file_route = generalLog.get_file_route();
        var file_content = fs.readFileSync(file_route + logFile);
        var str_file_content = file_content.toString();
        if (str_file_content === '') {
            var mes = message;
        } else {
            var mes = file_content + "\r\n" + message;
        }


        fs.writeFileSync(file_route + logFile, mes);
    }

}

exports.generalLog = generalLog;