@props(['value'])
@extends('components/layout')
@section('listcss')
@endsection
<label {{ $attributes->merge(['class' => 'text  font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
