@extends('auth.layouts.master')

@section('title', 'Купон ' . $coupon->code)

@section('content')
    <div class="col-md-12">
        <h1>{{ $coupon->code }}</h1>
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
                <td>{{ $coupon->id}}</td>
            </tr>
            <tr>
                <td>Код</td>
                <td>{{ $coupon->code }}</td>
            </tr>
            <tr>
                <td>Описание</td>
                <td>{{ $coupon->description }}</td>
            </tr>
            @isset($coupon->currency)
                <tr>
                    <td>Валюта</td>
                    <td>{{ $coupon->currency->code }}</td>
                </tr>
            @endisset
            <tr>
                <td>Абсолютное значениe</td>
                <td>{{ $coupon->isAbsolute() ? 'Да' : 'Нет' }}</td>
            </tr>
            <tr>
                <td>
                    Скидка
                </td>
                <td>
                    {{ $coupon->value }} {{ $coupon->isAbsolute() ? $coupon->currency->code : '%' }}
                </td>
            </tr>
            <tr>
                <td>
                    Количество использований
                </td>
                <td>
                    {{ $coupon->limit }}
                </td>
            </tr>
            <tr>
                <td>Использован:</td>
                <td>{{ $coupon->orders->count() }}</td>
            </tr>
            @if($coupon->expired_at)
                <tr>
                    <td>Действителен до:</td>
                    <td>{{ $coupon->expired_at->format('Y-m-d') }}</td>
                </tr>
            @endisset
            </tbody>
        </table>
    </div>
@endsection
