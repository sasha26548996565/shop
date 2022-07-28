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
            <p>{{ $sku->product->category->__('name') }}</p>
            <p>Осталось: {{ $sku->count }}</p>
            <p>{{ $sku->price }} {{ $currencySymbol }}</p>

            @isset($sku->product->properties)
                <p>
                    @foreach ($sku->propertyOptions as $propertyOption)
                        {{ $propertyOption->property->__('name') }} : {{ $propertyOption->__('name') }};
                    @endforeach
                </p>
            @endisset

            <form action="{{ route('basket-add', $sku->id) }}" method="POST">
                @csrf

                @if ($sku->isAvailable())
                    <button type="submit" class="btn btn-primary" role="button">{{ __('main.add_to_basket') }}</button>
                @else
                    {{ __('main.not_available') }}
                @endif
            </form>

            <a href="{{ route('sku', [$sku->product->category->slug, $sku->product->slug, $sku->id]) }}"
                class="btn btn-default">подробнее</a>
            </p>
        </div>
    </div>
</div>
