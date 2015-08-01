/**
 * Created by michael on 1/08/2015.
 */

//having issues with visual studio building apk's, here is the working code. I will keep improving it and upload changes to git.

    // Wait for device API libraries to load
    //
document.addEventListener("deviceready", onDeviceReady, false);

var watchID = null;
// device APIs are available

//This will grab the device's geolocation and pass it to the Onsuccess function.
function onDeviceReady() {
    // Throw an error if no update is received every 30 seconds
    var options = { timeout: 30000 };
    watchID = navigator.geolocation.watchPosition(onSuccess, onError, options);
}

// onSuccess Geolocation
//
function onSuccess(position) {
    var element = document.getElementById('geolocation');

    //test code, it will disply the gps cordants on the screen at the moment.
    document.getElementById("cords").innerHTML = ('Latitude: ' + position.coords.latitude + '<br />' +
    'Longitude: ' + position.coords.longitude + '<br />');
}

// onError Callback receives a PositionError object
function onError(error) {
    alert('code: ' + error.code + '\n' +
    'message: ' + error.message + '\n');
}

