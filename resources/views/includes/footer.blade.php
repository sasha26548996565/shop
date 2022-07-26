<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-6"><p>Категории товаров</p>
                <ul>
                    @foreach($categories as $category)
                        <li><a href="{{ route('category', $category->slug) }}">{{ $category->__('name') }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-6"><p>Самые популярные товары</p>
                <ul>
                    @foreach ($popularSkus as $sku)
                        <li><a href="{{ route('sku', [$sku->product->category->slug, $sku->product->slug, $sku->id]) }}">
                            {{ $sku->product->__('name') }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>
