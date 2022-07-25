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

            <select name="labels" multiple>
                @foreach ($labels as $field => $name)
                    <option value="{{ $field }}">{{ $name }}</option>
                @endforeach
            </select>

            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-primary">Фильтр</button>
                <a href="{{ route('index') }}" class="btn btn-warning">Сброс</a>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($skus as $sku)
            @include('card', compact('sku'))
        @endforeach
    </div>

    {{ $skus->links('includes.pagination') }}

@endsection
