@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row row-eq-height">
            @foreach ($movies as $movie)
            <div class="col-sm-4 col-md-2 col-lg-2">
                <div class="card card-index">
                    <a href="{{ route('movies.show', ['id'=>$movie->id]) }}">
                    @if($movie->poster_path != "")
                    <img class="card-img-top img-index" src="https://image.tmdb.org/t/p/w500/{{ $movie->poster_path }}" />
                    @else
                    <img src="/storage/noimage.jpg" width="100%" height="150" />
                    @endif
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
