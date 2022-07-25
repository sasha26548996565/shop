@extends('layouts.master')

@section('title', 'product')

@section('content')
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <img src="{{ asset(Storage::url($sku->product->image)) }}" alt="{{ $sku->product->name }}">

            <div class="caption">
                @foreach ($sku->product->getLabels() as $field => $name)
                    @if ($sku->product->issetLabel($field))
                        <span class="badge badge-success">{{ $name }}</span>
                    @endif
                @endforeach

                <h3>{{ $sku->product->__('name') }}</h3>
                <p>Осталось: {{ $sku->count }}</p>
                <p>{{ $sku->price }} </p>
                <p>{{ $sku->product->category->__('name') }}</p>

                @isset($sku->product->properties)
                    <p>
                        @foreach ($sku->propertyOptions as $propertyOption)
                            {{ $propertyOption->property->__('name') }} : {{ $propertyOption->__('name') }};
                        @endforeach
                    </p>
                @endisset

                @if ($sku->isAvailable())
                    <form action="{{ route('basket-add', $sku) }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-primary" role="button">{{ __('main.add_to_basket') }}</button>
                    </form>
                @else
                    <form action="{{ route('subscription', $sku->id) }}" method="POST">
                        @csrf

                        @guest
                            <input type="email" name="email" required>
                        @endguest

                        <input type="submit" class="btn btn-primary" value="сообщить когда тавор будет в наличии">
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
