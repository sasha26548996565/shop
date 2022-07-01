<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <img src="{{ asset(Storage::url($product->image)) }}" alt="{{ $product->name }}">

        <div class="caption">
            @foreach ($product->getLabels() as $field => $name)
                @if ($product->issetLabel($field))
                    <span class="badge badge-success">{{ $name }}</span>
                @endif
            @endforeach

            <h3>{{ $product->__('name') }}</h3>
            <p>Осталось: {{ $product->count }}</p>
            <p>{{ $product->price }} RUB</p>
            <p>

            @if ($product->isAvailable())
                <form action="{{ route('basket-add', $product->id) }}" method="POST">
                    @csrf

                    <input type="submit" class="btn btn-primary" value="корзина">
                </form>
            @else
                Нет на складе<br>
            @endif

            {{ $product->category->__('name') }}

            <a href="{{ route('product', [$product->category->slug, $product->slug]) }}"
                class="btn btn-default">подробнее</a>
            </p>
        </div>
    </div>
</div>
