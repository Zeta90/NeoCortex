// const { Request } = require(__dirname + '/request.js');
const { Paths } = require(__dirname + '/paths.js');

var coreApps = Paths.getPath('coreApps');

const { GetTime } = require(coreApps + '/time.js');
const { generalLog } = require(coreApps + '/generalLog.js');

class Log {

    static log_ignition_start() {
        var message = `[` + GetTime.getFullDate() + `][IGNITION]`;

        generalLog.feed_log('ignition.lg', message);

        //         var message = `********************************************************
        // *** NeoCortex 1.0.0 
        // *** Date start: ` + time + `
        // ********************************************************`;

        //         generalLog.feed_log('ignition.lg', message);
    }

    static log_application_started() {

        var message = `[` + GetTime.getFullDate() + `][WATCHDOG][START]`;

        generalLog.feed_log('ignition.lg', message);
    }

    static log_error(err, code) {

        var message = `[` + GetTime.getFullDate() + `] - [` + code + `][ERROR] ` + JSON.stringify(err);

        generalLog.feed_log('ignition.lg', message);
        exit();
    }

    // CONSOLE
    static console_event(message) {
        console.log(message);
    }
}

exports.Log = Log;