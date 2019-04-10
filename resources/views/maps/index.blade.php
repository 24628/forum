@extends('layouts.front')

@section('categories')

    @include('profile.partials.profileImage')

@endsection

@section('content')

    <div style="margin-left: 5px;">
        <h3>Click on the maps to make them bigger</h3>
        <br>
        @forelse($maps as $map)

            <div style="height: 200px; width: 200px;margin-bottom: 20px;margin-left: 15px;float: left;" id="map{{$map->id}}"></div>
            @include('maps.partials.map-preview')

        @empty

            <h3>You currently have 0 maps</h3>

        @endforelse
    </div>
@endsection

@section('js')
    <script>
        map{{$map->id}}.on('click', function(e){
            var coord = e.latlng;
            var lat = coord.lat;
            var lng = coord.lng;
            console.log("You clicked the map at latitude: " + lat + " and longitude: " + lng);
            location.href = "{{ route('map.show',['map' => $map->id]) }}";
        });
    </script>
@endsection