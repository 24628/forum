<script>
    var area = {
        "color": "#000000",
        "weight": 3,
        "opacity": 0.5
    };
    var small = {
        "color": "#dd3622",
        "weight": 1.5,
        "opacity": 1
    };
    var zipcodes = {
        "color": "#6ddd25",
        "weight": 2.33,
        "opacity": .7
    };
    var zones = {
        "color": "#070668",
        "weight": 2.76,
        "opacity": .6
    };
    var smallZones = {
        "color": "#61e735",
        "weight": 1.8,
        "opacity": .1
    };
    var test = L.geoJSON(GEBIEDEN22, {style: area});
    var test2 = L.geoJSON(GEBIEDEN22_EXWATER, {style: area});
    var test3 = L.geoJSON(GEBIEDEN25, {style: area});
    var test4 = L.geoJSON(GEBIEDEN25_EXWATER, {style: area});
    var test5 = L.geoJSON(GEBIED_BUURTEN, {style: small});
    var test6 = L.geoJSON(GEBIED_BUURTEN_EXWATER, {style: small});
    var test8 = L.geoJSON(PC4_BUURTEN, {style: zipcodes});
    var test9 = L.geoJSON(PC4_BUURTEN_EXWATER, {style: zipcodes});
    var test10 = L.geoJSON(PC6_VLAKKEN_BAG, {style: zipcodes});
    var test11 = L.geoJSON(GEBIED_STADSDELEN, {style: zones});
    var test12 = L.geoJSON(GEBIED_STADSDELEN_EXWATER, {style: zones});
    var test13 = L.geoJSON(GEBIED_BUURTCOMBINATIES, {style: smallZones});
    var test14 = L.geoJSON(GEBIED_BUURTCOMBINATIES_EXWATER, {style: smallZones});
    var overlays = {
        "Urban-22": test,
        "Urban-22 ex water": test2,
        "Urban-25": test3,
        "Urban-2 ex water<hr>": test4,
        "Neighborhoods": test5,
        "Neighborhoods ex water<hr>": test6,
        "Zipcode-4": test8,
        "Zipcode-4 Ex water": test9,
        "Zipcode-6<hr>": test10,
        "City-area": test11,
        "City-area ex water<hr>": test12,
        "Neighborhoods-combo": test13,
        "Neighborhoods-combo ex water": test14
    };
    var test7 = L.geoJSON(HOEGROOT);
    var test15 = L.geoJSON();
    var baseLayers = {
        "Amsterdams-area ON": test7,
        "Amsterdams-area OFF": test15
    };
    L.control.layers(baseLayers, overlays).addTo(map);
</script>