@extends('auth.layouts.master')

@section('title', 'sku ' . $sku->name)

@section('content')
    <div class="col-md-12">
        <h1>{{ $sku->product->name }}</h1>
        <h2>{{ $sku->propertyOptions->map->name->implode(', ') }}</h2>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Поле
                </th>
                <th>
                    Значение
                </th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $sku->id}}</td>
            </tr>

            <tr>
                <td>цена</td>
                <td>{{ $sku->price }}</td>
            </tr>

            <tr>
                <td>Кол-во</td>
                <td>{{ $sku->count }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
