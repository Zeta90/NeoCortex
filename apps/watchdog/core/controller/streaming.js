const { coreRedis } = require('/var/www/apps/api/apps/core/db/redis.js');

module.exports = {
    _connect: async function (params = null) {
        if (params !== null) {
            if (params.room !== null) {

                var config = {
                    headers: {
                        'SESSIONTOKEN': params.sessiontoken,
                        'AUTHTOKEN': 'watchdog-token',
                        'TOKENAGENT': 'watchdog-master',
                        'TOKENHOST': '0.0.0.100',
                    }
                }

                var api_response = null;

                const axios = require('axios');
                await axios
                    .get('http://neocortex.api/stream/open', config)
                    .then(res => {
                        api_response = res;
                    })
                    .catch(error => {
                        console.error(error)
                    });


                return api_response;
            }else{
            
            }
        }
    }
};
