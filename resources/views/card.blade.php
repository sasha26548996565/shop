<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
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

                <a href="{{ route('product', [$product->category->slug, $product->slug]) }}" class="btn btn-default">подробнее</a>
            </p>
        </div>
    </div>
</div>
