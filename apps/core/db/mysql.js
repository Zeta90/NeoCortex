const mysql = require('mysql2');

const { GetTime } = require(__dirname + '/time.js');
const { generalLog } = require(__dirname + '/generalLog.js');

class coreMySQL {

    server = null;
    __connection = null;
    query = null;

    constructor(server) {
        this.server = server;
    }

    __mysql_connect() {
        if (this.__connection === null) {
            this.__connection = mysql.createPool({
                host: this.server.host,
                port: this.server.port,
                user: this.server.userName,
                password: this.server.password
            });
        };
    }

    async __execute_query(query) {
        return new Promise((resolve, reject) => {
            this.__connection.query(query, (err, rows) => {
                if (err) {

                    // ERR REGISTER
                    this.mysql_err_log(err);
                    reject([err, false]);
                }

                rows.length--;
                resolve([rows, true]);
                // resolve(rows);
            });
        });
    }

    async execute_mysql_query(query) {

        this.__mysql_connect();

        var result = await this.__execute_query(query);

        var result_promise = new Promise(resolve => {
            resolve(result)
        })

        return result_promise;
    }



    async execute_mysql_SP(sp_name, sp_attrs = []) {

        this.__mysql_connect();

        var query = 'CALL ' + sp_name + '("' + sp_attrs.join('","') + '")';
        var result = await this.__execute_query(query);

        return new Promise(resolve => {
            resolve(result)
        })
    }

    async execute_mysql_action_SP(sp_name, sp_attrs = []) {

        const allowed_sp = {
            "get_pair_info": "qbroker.get_pair_info"
        }

        this.__mysql_connect();

        var query = 'CALL ' + allowed_sp[sp_name] + '("' + sp_attrs.join('","') + '")';

        var result = await this.__execute_query(query);

        return new Promise(resolve => {
            resolve(result)
        })
    }

    // Register Error
    mysql_err_log(err_msg) {
        var message = `[` + GetTime.getFullDate() + `][MYSQL][ERROR] -> ` + err_msg;

        generalLog.feed_log('mysql.lg', message);
    }

}

exports.coreMySQL = coreMySQL;