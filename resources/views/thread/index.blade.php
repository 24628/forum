@extends('layouts.front')

@section('banner')

    @guest
        <div class="jumbotron">
            <div class="container">
                <h1> Join Forum</h1>
                <p>help and get help</p>
                <p>
                    <a class="btn btn-primary btn-lg">Learn more</a>
                </p>
            </div>
        </div>
    @endguest

@endsection

@section('heading')
    <a class="btn btn-primary" href="{{route('thread.create')}}">Create Thread</a> <br>
@endsection

@section('content')

    @include('thread.partials.thread-list')

@endsection