@extends('layouts.front')

@section('categories')

    @include('profile.partials.profileImage')

@endsection

@section('content')

    <div>
        <h2>Activity Feeds</h2>
        @foreach($feeds as $feed)

            @include("feeds.$feed->type")

        @endforeach
    </div>

@endsection