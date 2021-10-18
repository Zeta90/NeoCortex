const { Paths } = require(__dirname + '/paths.js');

var coreApps = Paths.getPath('coreApps');

const { coreMySQL } = require(coreApps + 'mysql.js');
const { coreRedis } = require(coreApps + 'redis.js');
const { WDCrashLog } = require(__dirname + '/WDCrashLog.js');
const { Log } = require(__dirname + '/log.js');

class Igniter {

    servers_mysql = null;
    servers_redis = null;
    crash_files = null;

    async __full_ignition() {
        // Logging start
        Log.log_ignition_start();
        Igniter.console_ignition_start();

        // Loading static CFG
        var ignition_static = this.__load_static_cfg();
        var ignition_servers = ignition_static.servers;
        var ignition_cfg = ignition_static.ignition;

        // Loading Cache
        var main_cfg = await this.__load_main_cfg(ignition_servers);

        // this.cache = this.sort_cache_data(main_cfg[0]);

        this.servers_mysql = ignition_servers.mysql;
        this.servers_redis = ignition_servers.redis;

        // Crash Log
        // var crashLogResult = await WDCrashLog.manage_crash_log(this.servers_mysql);

        // if (crashLogResult === true) {
        //     Igniter.console_crash_loaded();
        // }

        var api_cache_loaded = await this.ignite_cache();

        if (api_cache_loaded === true) {
            Igniter.console_ignition_end();
        }

    }

    __load_WS_server(){
        
    }

    __load_static_cfg() {

        try {
            var fs = require(Paths.getPath('configFile'));
            Igniter.console_cfg_loaded();
        } catch (err) {
            Igniter.console_cfg_failed();
            Log.log_error(err, '001');
        }

        return fs;
    }

    async __load_main_cfg(mysql_servers) {

        var mysql = new coreMySQL(mysql_servers.mysql);

        var SP_query = 'CALL config.get_cached_config();';
        var get_global_cfg = await mysql.execute_mysql_query(SP_query);

        if (get_global_cfg[1] == false) {
            Igniter.console_cache_failed();
            Log.log_error(get_global_cfg[0], '003')
        }

        var promise_result = new Promise((resolve => {
            resolve(get_global_cfg);
        }));

        Igniter.console_cache_loaded();

        return promise_result;
    }

    // INFO & ERROR
    static console_ignition_start() {
        Log.console_event('IGNITION STARTED');
    }

    static console_ignition_end() {
        Log.console_event('IGNITION END');
    }

    static console_cfg_loaded() {
        Log.console_event('[OK] Loaded Main CFG');
    }

    static console_cfg_failed() {
        Log.console_event('[ERROR] Failed Main CFG');
    }

    static console_cache_loaded() {
        Log.console_event('[OK] Loaded Cache');
    }

    static console_cache_failed() {
        Log.console_event('[ERROR] Failed Cache');
    }


    static console_crash_loaded() {
        Log.console_event('[OK] Loaded CrashLog');
    }

    static console_api_cache_loaded() {
        Log.console_event('[OK] Loaded API Cache');
    }

    // -------------

    // API 
    sort_cache_data(ignition_data) {

        

        var i = 0;
        var ignition_cache = {};
        var key = null;

        ignition_data.forEach(function (table, table_id) {
            var fullarray = {};

            table.forEach(function (row, row_id) {

                var full_obj = {}

                var keys = (Object.keys(row));
                key = keys[0];

                var vals = (Object.values(row));

                vals.forEach(function (val) {
                    var data = null;
                    if (i > 0) {
                        if (typeof (val) == 'string' && (val.substring(0, 1) == '[' || val.substring(0, 1) == '{')) {
                            data = JSON.parse(val);
                            if (keys[i] == 'params') {
                                var param_k = (Object.keys(data));
                                var param_v = (Object.values(data));

                                var j = 0;

                                param_k.forEach(function (kk) {
                                    full_obj[kk] = param_v[j];
                                    j++;
                                })

                                j = 0;
                            } else {
                                full_obj[keys[i]] = data;
                            }


                        } else if (typeof (val) == 'string' && val.toString().substring(0, 1) == '{') {
                            data = JSON.parse(val);
                            full_obj[keys[i]] = data;
                            // data.forEach(function(c_table) {
                            //     console.log();
                            // });
                        } else {
                            data = val;
                            full_obj[keys[i]] = data;
                        }


                    }

                    i++;

                });

                i = 0;

                if (row[key].substring(0, 1) == '[') {
                    var kname = row[key];
                    var data = JSON.parse(kname);

                    data.forEach(function (k) {
                        fullarray[k] = full_obj;
                    })
                } else {
                    fullarray[row[key]] = full_obj;
                }

            });

            ignition_cache[key] = (fullarray);

        });

        return ignition_cache;
    }

    async ignite_cache() {
        var cache_servers = this.servers_redis;
        var cache_data = this.cache;

        var redis = new coreRedis(cache_servers);
        var database_cache = cache_servers.databases;

        var db = null;
        var key = 0;
        var value = null;

        // redis.flush_bucket(db)

        for(var i =0;i< 16;i++){
            redis.flush_bucket(i)
        }

        // var iMax = Object.keys(database_cache).length;
        // for (var i = 0; i < iMax; i++) {
        //     key = Object.keys(database_cache)[i];
        //     db = database_cache[key];
        //     value = cache_data[key];
        //     // value

        //     // if(i<7){
        //     //     redis.flush_bucket(db)
        //     // }

        //     if (value !== undefined) {
        //         var jMax = Object.keys(value).length;
        //         for (var j = 0; j < jMax; j++) {

        //             var jKey = Object.keys(value)[j];
        //             var jValue = JSON.stringify(value[jKey]);

        //             var get_global_cfg = await redis.setPairValue(jKey, jValue, db);

        //         }
        //     }

        // }

        Igniter.console_api_cache_loaded();
        return true;

        // database_cache.forEach(function(k, v) {
        //     var get_global_cfg = redis.setPairValue('aa', 'vv');

        //     return new Promise((resolve => {
        //         resolve(get_global_cfg);
        //     }))
        // })

    }

































    async __manage_crash_log(mysql_servers) {
        var getCrashJSON = WDCrashLog.getCrashesJSON();
        // console.log(getCrashJSON);

        var a = await WDCrashLog.push_crash_records_into_db(getCrashJSON);

        WDCrashLog.empty_crash_report_file()
    }









    static async resolve_api_feed(cache_servers, bucket_db) {

        var redis = new coreRedis(cache_servers.redis);
        var get_all_feed_bucket = await redis.getAllBucketPairValues(bucket_db);
        // var keys = [];

        var mysql = new coreMySQL(cache_servers);

        var count = get_all_feed_bucket.length;

        for (var i = 0; i < 5; i++) {
            // for (var i = 0; i < count; i++) {

            var key = get_all_feed_bucket[i][0];
            // keys.push(key);

            var val = JSON.parse(get_all_feed_bucket[i][1]);

            var time = val.time;
            var host = val.request.client.host;
            var port = val.request.client.port;
            var agent = val.request.client.agent;
            var code = val.response.code;
            var request = JSON.stringify(val.request).split('"').join("'");
            var response = JSON.stringify(val.response).split('"').join("'");
            var token = key;

            var feed_class = key.split('/');
            feed_class = feed_class[0];

            var SP_query = 'feeds_system.feed_app_access';
            var get_global_cfg = await mysql.execute_mysql_SP(SP_query, [time, host, port, agent, code, request, response, feed_class, token]);
        }

        redis.flush_bucket(null, 6);

        // var SP_query = 'CALL config.get_cached_config();';
        // var get_global_cfg = await mysql.execute_mysql_query(SP_query);

        return new Promise((resolve => {
            resolve(get_global_cfg);
        }))
    }
}

exports.Igniter = Igniter;