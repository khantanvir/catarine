var apiGeolocationSuccess = function (position) {
    createCookie("latitude",position.coords.latitude,7);
    createCookie("longitude",position.coords.longitude,7);
};

var tryAPIGeolocation = function () {
    jQuery.post(
        "https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyBKI8oyydmgWAtwdNXuX5K5l9E4eSbBCdk",
        function (success) {
            apiGeolocationSuccess({
                coords: {
                    latitude: success.location.lat,
                    longitude: success.location.lng
                }
            });
        })
        .fail(function (err) {
            alert("API Geolocation error! <br><br>" + err);
        });
};

var browserGeolocationSuccess = function (position) {
    createCookie("latitude",position.coords.latitude,7);
    createCookie("longitude",position.coords.longitude,7);
};

var browserGeolocationFail = function (error) {
    switch (error.code) {
        case error.TIMEOUT:
            alert("Browser geolocation error !<br><br>Timeout.");
            break;
        case error.PERMISSION_DENIED:
            if (error.message.indexOf("Only secure origins are allowed") == 0) {
                tryAPIGeolocation();
            }
            break;
        case error.POSITION_UNAVAILABLE:
            // dirty hack for safari
            if (error.message.indexOf("Origin does not have permission to use Geolocation service") == 0) {
                tryAPIGeolocation();
            } else {
                alert("Browser geolocation error !<br><br>Position unavailable.");
            }
            break;
    }
};

var tryGeolocation = function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            browserGeolocationSuccess,
            browserGeolocationFail, {
                maximumAge: 50000,
                timeout: 20000,
                enableHighAccuracy: true
            });
    }
};

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        expires = "; expires="+date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name+"="+value+expires+"; path=/";
}