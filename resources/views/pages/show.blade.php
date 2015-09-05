@extends('layouts.main')

@section('title', $page->title)

@section('content')
    <h2>{{ $page->title }}</h2>

    {!! $page->body !!}
@endsection