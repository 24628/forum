<script>
    let map{{$map->id}} = L.map('map{{$map->id}}').setView([52.37, 4.90], 18);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 14,
    }).addTo(map{{$map->id}});

    var obj{{$map->id}} = '';
    init{{$map->id}}();
    addLayers{{$map->id}}();

    function init{{$map->id}}() {
        let stringArray = '{{$map->data}}';
        let text = stringArray.replace(/&quot;/g, '"');
        try {
            obj{{$map->id}} = JSON.parse(text); // this is how you parse a string into JSON
            makeMap{{$map->id}}();
        } catch (error) {
            console.error(error);
        }
    }

    function makeMap{{$map->id}}() {
        console.log(obj{{$map->id}});
        var polygon{{$map->id}} = {};
        var polyline{{$map->id}} = {};
        var marker{{$map->id}} = {};
        for(let i = 0; i < obj{{$map->id}}.length; ++i){
            if(obj{{$map->id}}[i][1]['type'] === "Marker"){
                marker{{$map->id}}['counter' + i] = L.marker([obj{{$map->id}}[i][0].geometry.coordinates[1], obj{{$map->id}}[i][0].geometry.coordinates[0]]).addTo(map{{$map->id}});
                marker{{$map->id}}['counter' + i].bindPopup("<p>" + obj{{$map->id}}[i][1]['Status'] + "</p>");
            } else if(obj{{$map->id}}[i][1]['type'] === "Polygon"){
                if(obj{{$map->id}}[i][0].geometry.type === "Polygon"){
                    for(let b = 0; b < obj{{$map->id}}[i][0].geometry.coordinates[0].length; ++b){
                        let tmpPolygon = obj{{$map->id}}[i][0].geometry.coordinates[0][b][1];
                        obj{{$map->id}}[i][0].geometry.coordinates[0][b][1] = obj{{$map->id}}[i][0].geometry.coordinates[0][b][0];
                        obj{{$map->id}}[i][0].geometry.coordinates[0][b][0] = tmpPolygon;
                    }
                    polygon{{$map->id}}['counter' + i] = L.polygon(obj{{$map->id}}[i][0].geometry.coordinates, {color: 'red'}).addTo(map{{$map->id}});
                } else if(obj{{$map->id}}[i][0].geometry.type === "LineString"){
                    for(let k = 0; k < obj{{$map->id}}[i][0].geometry.coordinates.length; ++k){
                        let tmpPolyline = obj{{$map->id}}[i][0].geometry.coordinates[k][0];
                        obj{{$map->id}}[i][0].geometry.coordinates[k][0] = obj{{$map->id}}[i][0].geometry.coordinates[k][1];
                        obj{{$map->id}}[i][0].geometry.coordinates[k][1] = tmpPolyline;
                    }
                    polyline{{$map->id}}['counter' + i] = L.polyline(obj{{$map->id}}[i][0].geometry.coordinates, { color: 'red'}).addTo(map{{$map->id}});
                }
            }
        }
    }

    function addLayers{{$map->id}}() {
        var area{{$map->id}} = {
            "color": "#000000",
            "weight": 3,
            "opacity": 0.5
        };
        var small{{$map->id}} = {
            "color": "#dd3622",
            "weight": 1.5,
            "opacity": 1
        };
        var zipcodes{{$map->id}} = {
            "color": "#6ddd25",
            "weight": 2.33,
            "opacity": .7
        };
        var zones{{$map->id}} = {
            "color": "#070668",
            "weight": 2.76,
            "opacity": .6
        };
        var smallZones{{$map->id}} = {
            "color": "#61e735",
            "weight": 1.8,
            "opacity": .1
        };
        var test{{$map->id}} = L.geoJSON(GEBIEDEN22, {style: area{{$map->id}}});
        var test2{{$map->id}} = L.geoJSON(GEBIEDEN22_EXWATER, {style: area{{$map->id}}});
        var test3{{$map->id}} = L.geoJSON(GEBIEDEN25, {style: area{{$map->id}}});
        var test4{{$map->id}} = L.geoJSON(GEBIEDEN25_EXWATER, {style: area{{$map->id}}});
        var test5{{$map->id}} = L.geoJSON(GEBIED_BUURTEN, {style: small{{$map->id}}});
        var test6{{$map->id}} = L.geoJSON(GEBIED_BUURTEN_EXWATER, {style: small{{$map->id}}});
        var test8{{$map->id}} = L.geoJSON(PC4_BUURTEN, {style: zipcodes{{$map->id}}});
        var test9{{$map->id}} = L.geoJSON(PC4_BUURTEN_EXWATER, {style: zipcodes{{$map->id}}});
        var test10{{$map->id}} = L.geoJSON(PC6_VLAKKEN_BAG, {style: zipcodes{{$map->id}}});
        var test11{{$map->id}} = L.geoJSON(GEBIED_STADSDELEN, {style: zones{{$map->id}}});
        var test12{{$map->id}} = L.geoJSON(GEBIED_STADSDELEN_EXWATER, {style: zones{{$map->id}}});
        var test13{{$map->id}} = L.geoJSON(GEBIED_BUURTCOMBINATIES, {style: smallZones{{$map->id}}});
        var test14{{$map->id}} = L.geoJSON(GEBIED_BUURTCOMBINATIES_EXWATER, {style: smallZones{{$map->id}}});
        var overlays{{$map->id}} = {
            "Urban-22": test{{$map->id}},
            "Urban-22 ex water": test2{{$map->id}},
            "Urban-25": test3{{$map->id}},
            "Urban-2 ex water<hr>": test4{{$map->id}},
            "Neighborhoods": test5{{$map->id}},
            "Neighborhoods ex water<hr>": test6{{$map->id}},
            "Zipcode-4": test8{{$map->id}},
            "Zipcode-4 Ex water": test9{{$map->id}},
            "Zipcode-6<hr>": test10{{$map->id}},
            "City-area": test11{{$map->id}},
            "City-area ex water<hr>": test12{{$map->id}},
            "Neighborhoods-combo": test13{{$map->id}},
            "Neighborhoods-combo ex water": test14{{$map->id}}
        };
        var test7{{$map->id}} = L.geoJSON(HOEGROOT);
        var test15{{$map->id}} = L.geoJSON();
        var baseLayers{{$map->id}} = {
            "Amsterdams-area ON": test7{{$map->id}},
            "Amsterdams-area OFF": test15{{$map->id}}
        };
        L.control.layers(baseLayers{{$map->id}}, overlays{{$map->id}}).addTo(map{{$map->id}});
    }
</script>

