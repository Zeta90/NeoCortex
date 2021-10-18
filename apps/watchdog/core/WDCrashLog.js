const { Paths } = require(__dirname + '/paths.js');

var coreApps = Paths.getPath('coreApps');

const { coreMySQL } = require(coreApps + 'mysql.js');

class WDCrashLog {

    static async manage_crash_log(mysql_server) {
        var crash_info = WDCrashLog.getCrashesJSON();
        var crash_stored_response = await WDCrashLog.push_crash_records_into_db(crash_info, mysql_server);

        if (crash_stored_response[1] == true) {
            // WDCrashLog.empty_crash_report_file();
            return new Promise((resolve => {
                resolve(true);
            }))
        }

    }

    static getCrashesJSON() {
        var apiCrashFile = Paths.getPath('apiCrashFile');

        var fs = require('fs')
        var crash_records = fs.readFileSync(apiCrashFile, 'utf8');
        crash_records = crash_records.substring(0, crash_records.length - 1);

        try {
            var json_crash_records = JSON.parse('[' + crash_records + ']');
        } catch (ex) {
            console.log(ex);
            // ERROR PARSING JSON
        }
        return json_crash_records;
    }

    static async push_crash_records_into_db(crash_records, mysql_server) {
        var mysql_obj = new coreMySQL(mysql_server);

        var crash_params = WDCrashLog.sort_crash_info(crash_records);

        var SP_query = 'feeds_system.feed_error';
        var final_result = [];

        for (var i = 0; i < crash_params.length; i++) {
            var get_global_cfg = await mysql_obj.execute_mysql_SP(SP_query, crash_params[i]);
            final_result.push(get_global_cfg);
        }

        return new Promise((resolve => {
            resolve(get_global_cfg);
        }))
    }

    static sort_crash_info(crash_records) {
        var date = null;
        var host = null;
        var port = null;
        var agent = null;
        var request = null;
        var response = null;
        var errcode = null;

        var sorted_array = []

        crash_records.forEach(function(val, key) {

            var arr = [];
            date = val.date;
            host = val.request.client.host;
            port = val.request.client.port;
            agent = val.request.client.agent;
            errcode = val.response.code;
            request = JSON.stringify(val.request).split('"').join("'");
            response = JSON.stringify(val.response).split('"').join("'");

            arr = [date, host, port, agent, errcode, request, response];
            sorted_array.push(arr);
        });

        return sorted_array;
    }



    static empty_crash_report_file() {
        var crash_file = Paths.getPath('crash_file');

        var fs = require('fs');

        try {
            fs.writeFileSync(crash_file, '');
        } catch (err) {
            return err;
        }

        return true;
    }

}

exports.WDCrashLog = WDCrashLog;