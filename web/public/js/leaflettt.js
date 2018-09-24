/*function display_map(latitude,longitude)// pour afficher un seul marqueur
{

    let mymap = L.map('mapid').setView([48.8534, 2.3488], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapid',
        accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);

    L.marker([latitude, longitude]).addTo(mymap);

    
    
    let circle = L.circle([48.8534, 2.3488], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 250
    }).addTo(mymap);




    let popup = L.popup()
    .setLatLng([48.8534, 2.3488])
    .setContent("Hello world")
    .openOn(mymap);

}*/
 

function display_map()
{
   
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapid',
        accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);

}

function display_marker(latitude, longitude){

    L.marker([latitude, longitude]).addTo(mymap);
}




