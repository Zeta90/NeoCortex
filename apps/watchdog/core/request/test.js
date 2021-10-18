const { coreRedis } = require('/var/www/apps/api/apps/core/db/redis.js');

module.exports = {
  _connect: function (params = null) {
    if (params !== null) {
      if (params.room !== null) {

        var config = {
          headers: {
            sessionToken: params.sessiontoken,
            AUTHTOKEN: 'watchdog-token',
            TOKENAGENT: 'watchdog-master',
            TOKENHOST: '0.0.0.100',
          }
        }

        const axios = require('axios');
        axios
          .get('http://neocortex.api/stream/open', {}, config)
          .then(res => {
            console.log(`statusCode: ${res.status}`)
            return(res)
          })
          .catch(error => {
            console.error(error)
          });


        return 'stream connection';
      }
    }
  }
};