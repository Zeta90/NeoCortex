const redis = require("ioredis");
const { promisify } = require("util");

class coreRedis {

    client = null;
    server = null;

    redis_get = null;
    redis_set = null;
    redis_getList = null;

    constructor(cfg) {
        this.server = cfg;
    }

    async __setRedis() {

        this.client = new redis({
            port: this.server.port, // replace with your port
            host: this.server.host, // replace with your hostanme or IP address
            db: 1
            // password: 'your password', // replace with your password
            // optional, if using SSL
            // use `fs.readFile[Sync]` or another method to bring these values in
            // tls: {
            //     key: stringValueOfKeyFile,
            //     cert: stringValueOfCertFile,
            //     ca: [stringValueOfCaCertFile]
            // }
        });

        // this.selectRedisBucket(cfg.databases['feed_bucket_request']);


        // this.client.select(6, function(err, res) {
        //     // you'll want to check that the select was successful here
        //     // if(err) return err;
        //     console.log(1); // this will be posted to database 1 rather than db 0
        // });
        try {
            var ping = await this.__redisPing();
        } catch (ex) {
            console.log(ex);
        }

        if (ping === 'PONG') {
            return 1;
        } else {
            return 3;
        }

        // this.client.on("error", function(error) {
        //     console.error(error);
        // });
    }

     __deleteRecord(key) {
        var result = this.__del(key);

        return new Promise(resolve => {
            resolve(result);
        })
    }

     __getValue(key) {
        var result = this.__get(key);
        return new Promise(resolve => {
            resolve(result);
        })
    }















    async flush_bucket(bucket = -1) {
        await this.client.flushall();
        // this.selectRedisBucket(bucket)

        // var final_result = [];

        // var keys = await this.client.keys("*");

        // var count = keys.length;

        // for (var i = 0; i < count; i++) {
        //     var res = await this.client.del(keys[i]);
        // }

        return new Promise(resolve => {
            resolve();
        })
    }

    getPairValue(key) {

        const redis_result = this.client.get(key, function (err, result) {
            if (err) {
                console.error(err);
            } else {
                console.log(result); // Promise resolves to "bar"
            }
        });

        return redis_result;
    }

    async getAllBucketKeys(database) {

        await this.__select(database)

        var final_result = [];

        var keys = await this.__keys('*');
        // return keys;
        // var count = keys.length;

        // for (var i = 0; i < count; i++) {
        //     var res = await this.client.get(keys[i]);

        //     final_result.push([keys[i], res]);
        // }

        return new Promise(resolve => {
            resolve(keys);
        })
    }

    async __redisPing() {
        return new Promise(resolve => {
            resolve(this.client.ping());
        })
    }

    async __keys(key) {
        return new Promise(resolve => {
            resolve(this.client.keys(key));
        })
    }

    async __select(db) {
        return new Promise((resolve, reject) => {
            resolve(this.client.select(db));
        })
    }

    async __del(key) {
        return new Promise((resolve, reject) => {
            resolve(this.client.del(key));
        })
    }

    async __get(key) {
        return new Promise((resolve, reject) => {
            resolve(this.client.get(key));
        })
    }




























    async setPairValue(key, val, db = null) {

        if (db !== null) {
            this.selectRedisBucket(db)
        }

        var redis_key = null;
        redis_key = await this.client.set(key, val)

        return new Promise(resolve => {
            resolve(this.define_results(redis_key))
        })
    }

    define_results(result) {
        if (result === 'OK') {
            return true;
        } else {
            return false;
        }
    }
}

exports.coreRedis = coreRedis;




















// const { coreMySQL } = require(__dirname + '/mysql.js');
// // const redis = require('redis');
// // const mysql = require('mysql');

// class Feed {

//     feed_index = null;

//     constructor() {
//         this.feed_index = [0, 0]
//         this.feed_redis_buckets = [8, 9]
//     }

//     get_mysql_feed_data(pair_name, time_start, time_end) {
//         coreMySQL.execute_mysql_SP('get_raw_financial_records', [pair_name, time_start, time_end]);
//     }

//     setRedis() {
//         this.feeds = redis.createClient({
//             port: 6379, // replace with your port
//             host: '120.0.0.1', // replace with your hostanme or IP address
//             // password: 'your password', // replace with your password
//             // optional, if using SSL
//             // use `fs.readFile[Sync]` or another method to bring these values in
//             // tls: {
//             //     key: stringValueOfKeyFile,
//             //     cert: stringValueOfCertFile,
//             //     ca: [stringValueOfCaCertFile]
//             // }
//         });
//     }

//     getPairValue(key) {

//         redis.get('key', function(err, value) {
//             if (err) {
//                 throw err
//             }
//         });
//     }

// }

// exports.Feed = Feed;