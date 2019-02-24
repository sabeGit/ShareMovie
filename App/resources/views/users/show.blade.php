@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-img">
        <img src="{{ $src }}" />
    </div>
    <div class="username">
        {{ $user->name }}
    </div>
    <user-navbar></user-navbar>
</div>
@endsection
