class GetTime {

    static getTimeEPOCH_ms() {
        return new Date().getTime();
    }

    static getFullDate() {
        let ts = Date.now();

        let date_ob = new Date(ts);
        let date = date_ob.getDate();
        let month = date_ob.getMonth() + 1;
        let year = date_ob.getFullYear();
        let hour = date_ob.getHours();
        let min = date_ob.getMinutes();
        let sec = date_ob.getSeconds();

        return (date + "/" + month + "/" + year + ' ' + hour + ':' + min + ':' + sec);
    }

}

exports.GetTime = GetTime;