@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('お店を検索') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('search.get') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="freeword" class="col-sm-4 col-form-label text-md-right">{{ __('キーワード') }}</label>

                            <div class="col-md-6">
                                <input id="freeword" type="text" name="freeword" value="{{ old('freeword') }}" placeholder="例）ラーメン二郎 三田" size="40">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('検索') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @include('restaurants.index', ['rests' => $rests, 'noimage' => $noimage])
        </div>
    </div>
</div>
@endsection
