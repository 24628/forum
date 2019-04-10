console.log('Hello World');

function markNotificationAsRead(notificationCount){
    if(notificationCount !== '0')
    $.get('/markAsRead')
}

$( ".leaflet-bottom.leaflet-right" ).hide();