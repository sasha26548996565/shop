@extends('layouts.master')

@section('title', 'product')

@section('content')
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <img src="{{ asset(Storage::url($product->image)) }}" alt="{{ $product->name }}">

            <div class="caption">
                @foreach ($product->getLabels() as $field => $name)
                    @if ($product->issetLabel($field))
                        <span class="badge badge-success">{{ $name }}</span>
                    @endif
                @endforeach

                <h3>{{ $product->name }}</h3>
                <p>Осталось: {{ $product->count }}</p>
                <p>{{ $product->price }} RUB</p>
                <p>{{ $product->category->name }}</p>

                @if ($product->isAvailable())
                    <form action="{{ route('basket-add', $product->id) }}" method="POST">
                        @csrf

                        <input type="submit" class="btn btn-primary" value="корзина">
                    </form>
                @else
                    Нет на складе<br><br>

                    <form action="{{ route('subscription', $product->id) }}" method="POST">
                        @csrf

                        @guest
                            <input type="email" name="email" required class="form-control" placeholder="email"
                                value="{{ old('email') }}"><br>
                        @endguest
                        <input type="submit" class="btn btn-dark" value="Сообщить когда товар будет в наличии">
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
