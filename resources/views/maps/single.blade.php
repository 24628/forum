@extends('layouts.front')

@section('categories')

    @include('profile.partials.profileImage')

@endsection

@section('content')

    <div class="grid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div style="height: 700px; width: 700px;margin-bottom: 20px;margin-left: 15px;float: left;" id="map{{$map->id}}"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div>
                    <a href="{{ url()->previous() }}" style="margin-left: 5px;margin-right: 5px" class="btn btn-primary btn-sm float-left">Go back</a>
                    <a href="" style="margin-left: 5px;margin-right: 5px" class="btn btn-info btn-sm float-left">Edit</a>
                    <form style="margin-left: 5px;margin-right: 5px" class="float-left" method="post"
                          action="{{ route('map.destroy',['map' => $map->id]) }}"
                          onsubmit="return confirm('You sure you want to delete this map?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{URL::asset('/js/jsonAmsterdam.js')}}"></script>
    @include('maps.partials.map-preview')

@endsection