@extends('layouts.seller')

@section('title', $title ?? 'Seller Center')

@section('content')
    {{ $slot }}
@endsection
