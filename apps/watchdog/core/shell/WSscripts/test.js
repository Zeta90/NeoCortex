class WSscript_test {

    static router(request) {

        var route = (request.resource)
        route= route.split('/');

        const path = './WSscripts/' + route[1] + '.js';

        fs.access(path, fs.F_OK, (err) => {
            if (err) {
                console.error(err)
                return
            }
        })


    }

}

exports.WSscript_test = WSscript_test;
