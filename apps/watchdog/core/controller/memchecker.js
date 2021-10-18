const { Paths } = require('../paths.js');

var coreApps = Paths.getPath('coreApps');
const { coreRedis } = require(coreApps + 'db/redis.js');

class MemChecker {

    redis = null;
    // WSScontroller = null;

    constructor(servers) {
        this.redis = new coreRedis(servers.redis);
    }

    async __setRedis() {
        await this.redis.__setRedis();
    }

    async dispatch() {

        var err_keys = [];
        var ok_keys = [];

        while (true) {

            var bucket_data = await this.redis.getAllBucketKeys(0);

            await bucket_data.forEach(async (el) => {

                if (el.length !== 10) {
                    err_keys.push(el);
                } else {
                    var target_key = el;
                    var session_val = await this.redis.__getValue(target_key);
                    session_val = JSON.parse(session_val);

                    if (session_val['keep_session'] === false) {
                        var session_start = session_val['session_start'];
                        var session_time = session_val['session_time'];

                        if (parseInt(session_time) <= parseInt(session_start) * 10 * 60 * 1000) {
                            console.log(11)
                            var a = await this.redis.__deleteRecord(target_key);
                        }
                    }

                    console.log(session_val)
                }
            });

            // delete wrong keys
            // var a = await this.redis.__deleteRecord(err_keys);

            err_keys = [];
            ok_keys = [];

            await this.resolve();

        }
    }

    async resolve() {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve('resolved');
            }, 2000);
        });
    }
}

exports.MemChecker = MemChecker;