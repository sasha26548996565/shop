@extends('layouts.master')

@section('title', __('main.basket'))

@section('content')
    <h1>Корзина</h1>
    <p>Оформление заказа</p>
    <div class="panel">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Стоимость</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($order))
                    @foreach ($order->products as $product)
                        <tr>
                            <td>
                                <a href="{{ route('product', [$product->category->slug, $product->slug]) }}">
                                    <img height="56px" src="http://internet-shop.tmweb.ru/storage/products/iphone_x.jpg">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td><span class="badge">{{ $product->pivot->count }}</span>
                                <div class="btn-group form-inline">
                                    <form action="{{ route('basket-remove', $product) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" href=""><span
                                                class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
                                    </form>
                                    <form action="{{ route('basket-add', $product) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" href=""><span
                                                class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->getTotalPrice($product->pivot->count) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>корзина пуста</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3">Общая стоимость:</td>
                    @isset ($order)
                        <td>{{ $order->getFullPrice() }}</td>
                    @endisset
                </tr>
            </tbody>
        </table>
        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{ route('basket-place') }}">Оформить
                заказ</a>
        </div>
    </div>
@endsection
