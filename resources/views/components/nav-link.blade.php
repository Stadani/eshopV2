@props(['active'])
@extends('components/layout')
@section('listcss')
@endsection
@php
$classes = ($active ?? false)
            ? 'nav_button text ease-in-out '
            : 'nav_button text transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
