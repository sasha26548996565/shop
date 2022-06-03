@extends('layouts.master')

@section('title', 'category: {{ $category->name }}')

@section('content')
    <div class="starter-template">
        <h1>
            {{ $category->name }} {{ $category->products->count() }}
        </h1>
        <p>
           {{ $category->description }}
        </p>
        <div class="row">
            @foreach ($category->products as $product)
                @include('card', $product)
            @endforeach
        </div>
    </div>
@endsection
