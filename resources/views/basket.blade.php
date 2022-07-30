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
                @foreach ($order->skus as $sku)
                    <tr>
                        <td>
                            <a href="{{ route('sku', [$sku->product->category->slug, $sku->product->slug, $sku->id]) }}">
                                <img height="56px" src="{{ asset(Storage::url($sku->product->image)) }}">
                                {{ $sku->product->name }}
                            </a>
                        </td>
                        <td><span class="badge">{{ $sku->countInOrder ?? 1 }}</span>
                            <div class="btn-group form-inline">
                                <form action="{{ route('basket-remove', $sku->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" href=""><span
                                            class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
                                </form>
                                <form action="{{ route('basket-add', $sku->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" href=""><span
                                            class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                </form>
                            </div>
                        </td>
                        <td>{{ $sku->price }} {{ $currencySymbol }}</td>
                        <td>{{ $sku->price * ($sku->countInOrder) }} {{ $currencySymbol }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Общая стоимость:</td>

                    @isset ($order)
                        <td>
                            @isset ($order->coupon)
                                {{ $order->getFullSumWithCoupon() }}
                            @else
                                {{ $order->getFullSum() }}
                            @endisset

                            {{ $currencySymbol }}
                        </td>
                    @endisset
                </tr>
            </tbody>
        </table>
        <br>

        <div class="row">
            <div class="form-inline pull-right">
                @if ($order->hasCoupon())
                    <p>{{ __('basket.coupon.your_coupon') }} {{ $order->coupon->code }}</p>
                @else
                    <form method="POST" action="{{ route('basket-coupon-save') }}">
                        @csrf

                        @include('auth.layouts.error', ['fieldName' => 'coupon'])

                        <label for="coupon">{{ __('basket.coupon.add_coupon') }}:</label>
                        <input class="form-control" type="text" name="coupon">

                        <button type="submit" class="btn btn-success">{{ __('basket.coupon.apply') }}</button>
                    </form>
                @endif
            </div>
        </div>

        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{ route('basket-place') }}">Оформить
                заказ</a>
        </div>
    </div>
@endsection
