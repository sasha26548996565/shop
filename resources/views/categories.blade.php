@extends('layouts.master')

@section('title', __('main.all_categories'))

@section('content')
    @foreach ($categories as $category)
        <div class="panel">
            <a href="{{ route('category', $category->slug) }}">
                <img src="{{ asset(Storage::url($category->image)) }}" style="max-width: 500px;">
                <h2>{{ $category->__('name') }}</h2>
            </a>
            <p>
                {{ $category->__('description') }}
            </p>
        </div>
    @endforeach
@endsection
