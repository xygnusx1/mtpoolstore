@extends('layouts.base')

@section('scripts')
    @yield('page-scripts')
@endsection

@section('body')
<div class="topnav">
    <a class="active" href="#home">Home</a>
    @foreach($navtree as $tree)
    <a href="{{ $tree['url'] }}">{{ $tree['title'] }}</a>
    @endforeach
</div>

    @yield('content')

    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
