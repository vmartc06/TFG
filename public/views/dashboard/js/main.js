document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('deviceMap').setView([43.38596426941435, -8.406496608796404], 16);

    var customPin = L.icon({
        iconUrl: customPinURL, // path to your SVG
        iconSize:     [32, 32], // size of the icon
        iconAnchor:   [16, 32], // point of the icon which will correspond to marker's location
        popupAnchor:  [0, -32]  // point from which the popup should open relative to the iconAnchor
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([43.38596426941435, -8.406496608796404], {icon: customPin})
        .addTo(map)
});

function notify() {
    $.notify({
        icon: 'la la-bell',
        title: 'Bootstrap notify',
        message: 'Turning standard Bootstrap alerts into "notify" like notifications',
    },{
        type: 'success',
        placement: {
            from: "bottom",
            align: "right"
        },
        time: 1000,
    });
}