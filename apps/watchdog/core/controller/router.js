module.exports = {
    getRoutes: function () {
        const fs = require('fs');
        var rawdata = fs.readFileSync('/var/www/apps/api/core/cfg/routes.json');
        var routes = JSON.parse(rawdata, true);

        var route = null;
        var routes_filtered = [];

        for (route in routes) {
            if (routes[route].WD_trazable === true) {
                var fncts = null;
                routes_filtered[route] = [];
                for (fncts in routes[route].get_functions) {
                    console.log(routes[route].get_functions[fncts])
                    if (routes[route].get_functions[fncts].WD_function === true) {
                        routes_filtered[route][fncts] = routes[route].get_functions[fncts];
                    }
                };
            }
        };

        return routes_filtered;
    }
}