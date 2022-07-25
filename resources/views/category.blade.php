@extends('layouts.master')

@section('title', 'category:' . $category->__('name'))

@section('content')
    <h1>
        {{ $category->__('name') }} {{ $category->products->count() }}
    </h1>
    <p>
        {{ $category->__('description') }}
    </p>
    <div class="row">
        @foreach ($category->products->map->skus->flatten() as $sku)
            @include('card', $sku)
        @endforeach
    </div>
@endsection
