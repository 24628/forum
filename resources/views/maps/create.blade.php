@extends('layouts.front')

@section('ajax')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('categories')

    @include('profile.partials.profileImage')

@endsection

@section('content')


    <p id="demo"></p>

    <div style="height: 700px; width: 100%;" id="map"></div>

    <br>
    <button type="button" class="btn btn-primary" onclick="saveInDb()">Save map</button>
@endsection

@section('js')
    <script src="{{URL::asset('/js/jsonAmsterdam.js')}}"></script>
    <script>

        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }
        });

        let arrayAllDrawings = [];
        let map = L.map('map').setView([52.37, 4.90], 13);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        }).addTo(map);
        let editableLayers = new L.FeatureGroup();
        map.addLayer(editableLayers);

        L.control.scale().addTo(map);

        let options = {
            position: 'topright',
            draw: {
                polyline: true,
                polygon: {
                    allowIntersection: false, // Restricts shapes to simple polygons
                    drawError: {
                        color: '#3d37e1' // Color the shape will turn when intersects
                    }
                },
                circle: false, // Turns off this drawing tool
                rectangle: true,
                marker: true
            },
            // edit: {
            //     featureGroup: editableLayers, //REQUIRED!!
            //     remove: false
            // }
        };

        let drawControl = new L.Control.Draw(options);
        map.addControl(drawControl);

        map.on(L.Draw.Event.CREATED, function(e) {
            let type = e.layerType,
                layer = e.layer;
                reset();
            function  reset() {

                if (type === 'marker') {
                    let text = prompt("Please enter your pointer name:", "Insert pointer name");
                    if (text == null || text == "") {
                        alert('no input');
                        reset();
                    } else {
                        layer.bindPopup(text);
                        console.log(layer);
                        let shape = layer.toGeoJSON();
                        console.log(shape);
                        let shapeDB = shape;
                        let data = JSON.parse('{ "type": "Marker", "Status": "' + text + '" }');
                        let shape_for_db = [];
                        shape_for_db.push(shapeDB);
                        shape_for_db.push(data);
                        editableLayers.addLayer(layer);
                        saveInArray(shape_for_db);
                    }
                } else {
                    console.log('in case of marker this should not be logged!');
                    editableLayers.addLayer(layer);
                    let shape = layer.toGeoJSON();
                    console.log(shape);
                    let data = JSON.parse('{ "type": "Polygon", "Status": "Drawn" }');
                    let shape_for_db = [];
                    shape_for_db.push(shape);
                    shape_for_db.push(data);
                    saveInArray(shape_for_db);
                }
            }
        });

        function saveInArray(shape_for_db) {

            arrayAllDrawings.push(shape_for_db);
            console.log(arrayAllDrawings);
        }

        function saveInDb() {
            if (typeof arrayAllDrawings !== 'undefined' && arrayAllDrawings.length > 0) {
                $.ajax({
                    method: 'POST', // Type of response and matches what we said in the route
                    url: '{{ route('map.store') }}', // This is the url we gave in the route
                    data: {'mapData' : arrayAllDrawings},
                    success: function(response){ // What to do if we succeed
                        console.log(response);
                        alert('map is saved!');
                        location.href = "{{ route('map.index') }}";
                    },
                    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        alert('Failed to upload to the map');
                    }
                });
            } else {
                alert('The map has nothing on it!');
            }
        }

    </script>
    @include('maps.partials.jscheckbox')
@endsection