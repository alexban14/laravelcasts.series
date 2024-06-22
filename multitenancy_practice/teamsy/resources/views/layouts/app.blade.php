@extends('layouts.base')

@section('body')
    <x-navigation/>
    @yield('content')

    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
