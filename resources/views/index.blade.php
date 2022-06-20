@extends('layouts.master')

@section('title', 'home page')

@section('content')
    <h1>Все товары</h1>
    <form method="GET" action="">
        <div class="filters row">
            <div class="col-sm-6 col-md-3">
                <label for="price_from">Цена от <input type="text" name="price_from" id="price_from"
                    value="{{ request()->price_from }}" size="6" value="">
                </label>
                <label for="price_to">до <input type="text" name="price_to" id="price_to"
                    value="{{ request()->price_to }}" size="6" value="">
                </label>
            </div>

            @foreach ($labels as $field => $name)
                <div class="col-sm-2 col-md-2">
                    <label for="{{ $field }}">
                        <input type="checkbox" name="{{ $field }}" id="{{ $field }}"
                        @checked(request()->has($field)) > {{ $name }} </label>
                </div>
            @endforeach

            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-primary">Фильтр</button>
                <a href="{{ route('index') }}" class="btn btn-warning">Сброс</a>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($products as $product)
            @include('card', compact('product'))
        @endforeach
    </div>

    {{ $products->links('includes.pagination') }}

@endsection
