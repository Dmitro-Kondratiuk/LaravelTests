@props(['required'=>false])

@php
$required = $required ? 'required': null;
@endphp

<input {{$attributes}}  {{$required}}>
