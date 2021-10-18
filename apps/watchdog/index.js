class WatchDog {

    core = null;

    constructor() {
        const Core = require(__dirname + '/core/core.js');
        Core.ignition();
    }
}

const WD = new WatchDog();
// WD.manage_crash_log();