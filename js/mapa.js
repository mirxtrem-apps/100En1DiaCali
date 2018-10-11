$(window).load(function initialize() {

    var map;
    var infowindow = null;
    var marker;
    var xmlhttp = new XMLHttpRequest();
    var query = null;
    const api_key = "AIzaSyAn-v2Ao3s3l7Cqrr6XN2dwni-oRyutf20"
    var url_base = "https://www.googleapis.com/fusiontables/v2/query?";
    xmlhttp.open("GET", url_base +
        "sql=SELECT 'Geolocalizacion', 'Nombre de la actividad', 'Descripción','Categoría','Organización','Dirección','Barrio / Comuna','¿A quién va dirigida?','Nombre de Contacto','e-mail','Celular' FROM 1LpCQEVj4FGOGTdJm7Rfx-VCZEPFux_A9x8S438wr &key=" + api_key,
        true);
    xmlhttp.send();
    // Response HTTP
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (query == null) {
                insertMarkers(this.response);
            }
        }
    }
    function insertMarkers(response) {
        // Crear el mapa
        map = L.map('map').setView([3.4105945, -76.583122], 12);
        // Add Tile Layer
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={access_token}', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.light',
            access_token: 'pk.eyJ1IjoibWlyeHRyZW0iLCJhIjoiY2l3YXI5NmVqMDQzbDJ5cGZpbmZwNzVtZCJ9.wYBN9RmVckNydIjQ7u4u5Q'
        }).addTo(map);
        var marker100 = L.icon({
            iconUrl: '/images/marker100.svg'
        });
        // Obtenemos la lista de acciones
        var listaAcciones = JSON.parse(response);
        listaAcciones.rows.forEach(accion => {
            var coords = accion[0].split(',');
            var nombre = accion[1];
            var descripcion = accion[2];
            var categoria = accion[3];
            var organizacion = accion[4];
            var direccion = accion[5];
            var comuna = accion[6];
            var target = accion[7];
            var contacto = accion[8];
            var email = accion[9];
            var celular = accion[10];
            var lat = parseFloat(coords[0]);
            var lng = parseFloat(coords[1]);
            marker = L.marker([lat, lng], { icon: marker100 }).addTo(map);
            attachMessage(nombre, descripcion,categoria,organizacion,direccion,comuna, target, contacto, email,celular);
        });

        function attachMessage(nombre, desc,cat, org, dir, comn, target, contacto, email, cel) {

            marker.addEventListener('click', function () {
                var contenido = document.createElement('div');
                contenido.innerHTML = '<div><h3 class="tugsten-semibold secondary-text">'+ nombre + '</h3><p style="font-size:16px;text-align:left" class="avenir-light"><b>Organiza:</b> ' + org + '<br><b>Categoria: </b>' + cat + '<br><b>Dirección:</b> ' + dir + '<br><b>Comuna:</b> ' + comn + '</p><p style="font-size:16px; text-align:justify" class="avenir-light">' + desc + '</p><p style="font-size:16px;text-align:left" class="avenir-light"><b>¿A Quíen va dirigida?</b><br> ' + target + '<br><br><b>Contacto: </b>' + contacto + '<br><b>Correo:</b> ' + email + '<br><b>Celular:</b> ' + cel + '</p></div>';
                swal({
                    content: contenido,
                });
            });

        }
    }
});