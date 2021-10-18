const path = require('path');

class Paths {

    static getPath(point_arrow) {
        switch (point_arrow) {
            case 'coreApps':
                return Paths.__getRoot() + 'core/';
                break;

            case 'configFile':
                return Paths.__getRoot() + 'cfg/config.json';
                break;

            case 'crashFile':
                return Paths.__getRoot() + '_control/watchdog/crash.lg';
                break;

            case 'apiCrashFile':
                return Paths.__getApi() + '_control/crash.lg';
                break;
        }
    }

    static __getRoot() {
        return path.join(__dirname, '../../');
    }

    static __getApi() {
        return path.join(__dirname, '../../../');
    }

}

exports.Paths = Paths;