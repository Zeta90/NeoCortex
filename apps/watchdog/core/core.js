// const { MemChecker } = require(__dirname + '/controller/memchecker.js');
// const { WSserver } = require(__dirname + '/shell/WSserver.js');
// const { Paths } = require(__dirname + '/paths.js');

// class Core {

//     servers = null;
//     // shell
//     WSserver = null;
//     memchecker = null;
//     // WSScontroller = null;
//     config = null;

//     constructor() {

//         this.config = require(Paths.getPath('configFile'));
//         this.WSserver = new WSserver();
//     }

//     async start(){
//         await this.WSserver.createNewWSServer();

//         // this.memchecker = new MemChecker(this.config.servers);       
//         // await this.memchecker.__setRedis();
//         // await this.memchecker.dispatch();

//         // await this.memchecker.dispatch();

//     }

// }

// exports.Core = Core;

module.exports = {
    ignition: async function () {       
        var config = require('/var/www/apps/api/apps/cfg/config.json');

        const WSserver = require(__dirname + '/shell/WSserver.js');
        var server = await WSserver.createNewWSServer();
        await WSserver.startRequestProcessing(server);
  }
}