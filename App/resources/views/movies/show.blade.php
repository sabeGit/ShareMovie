@extends('layouts.app')

@section('content')
    <div class="container">
            <div class="row movie-detail">
                <div class="col-sm-4 col-md-3 col-lg-3">
                    <div class="card card-show">
                    @if ($movie->poster_path != "")
                        <img class="card-img-top img-show"  src="https://image.tmdb.org/t/p/w500/{{ $movie->poster_path }}" />
                    @else
                        <img src="/storage/noimage.jpg" width="100%" height="150" />
                    @endif
                    </div>
                </div>
                <div class="col-sm-8 col-md-9 col-lg-9">
                    <h1 class="movie-title">
                        {{ $movie->title }}
                    </h1>
                    <dl>
                        <dt>主演</dt>
                        @foreach ($creditArray['casts'] as $cast)
                            <dd>
                                <a href="#">{{ $cast->name }}</a>
                                @if ($cast != end($creditArray['casts']))
                                    <span>,</span>
                                @endif
                            </dd>
                        @endforeach
                        <dt>監督</dt>
                        @foreach ($creditArray['crews'] as $crew)
                            <dd>
                                <a href="#">{{ $crew->name }}</a>
                                @if ($crew != end($creditArray['crews']))
                                    <span>,</span>
                                @endif
                            </dd>
                        @endforeach
                    </dl>
                    <div class="movie-overview">
                        {{ $movie->overview }}
                    </div>
                    <show-actions movie="{{ json_encode($movie) }}"></show-actions>
                    <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/SUXWAEX2jlg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                </div>
            </div>
        </div>
    </div>
@endsection
