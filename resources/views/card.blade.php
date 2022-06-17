<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        @foreach ($product->getLabels() as $field => $name)
            @if ($product[$field] == 1)
                <span class="badge badge-success">{{ $name }}</span>
            @endif
        @endforeach

        {{-- @if ($product->isNewest())
            <span class="badge badge-success">Новинка</span>
        @endif

        @if ($product->isRecommend())
            <span class="badge badge-warning">Рекомендуем</span>
        @endif

        @if ($product->isHit())
            <span class="badge badge-danger">Хит продаж!</span>
        @endif --}}

        <img src="{{ asset(Storage::url($product->image)) }}" alt="iPhone X 64GB">
        <div class="caption">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->price }}</p>
            <p>
            <form action="{{ route('basket-add', $product->id) }}" method="POST">
                @csrf

                <input type="submit" class="btn btn-primary" value="корзина">
            </form>

            {{ $product->category->name }}

            <a href="{{ route('product', [$product->category->slug, $product->slug]) }}"
                class="btn btn-default">подробнее</a>
            </p>
        </div>
    </div>
</div>
