<?php

namespace App\Http\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    private const PRICE_FROM = 'price_from';
    private const PRICE_TO = 'price_to';
    private const LABELS = 'labels';

    public function getCallbacks(): array
    {
        return [
            self::PRICE_FROM => [$this, 'priceFrom'],
            self::PRICE_TO => [$this, 'priceTo'],
            self::LABELS => [$this, 'labels'],
        ];
    }

    public function priceFrom(Builder $builder, $value): void
    {
        $builder->where('price', '>=', $value);
    }

    public function priceTo(Builder $builder, $value): void
    {
        $builder->where('price', '<=', $value);
    }

    public function labels(Builder $builder, $value): void
    {
        foreach (['hit', 'recommend', 'newest'] as $label)
        {
            if ($value == $label)
            {
                $builder->whereHas('product', function ($query) use ($label) {
                    $query->where($label, 1);
                });
            }
        }
    }
}
