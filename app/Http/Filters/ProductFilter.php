<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    // public const CATEGORY_ID = 'category_id';
    // public const TAGS = 'tags';
    // public const SEARCH = 'search';

    // protected function getCallbacks(): array
    // {
    //     return [
    //         self::CATEGORY_ID => [$this, 'categoryId'],
    //         self::TAGS => [$this, 'tags'],
    //         self::SEARCH => [$this, 'search']
    //     ];
    // }

    // public function categoryId(Builder $builder, $value)
    // {
    //     $builder->where('category_id', $value);
    // }

    // public function tags(Builder $builder, $value)
    // {
    //     $postIds = PostTag::whereIn('tag_id', $value)->get()->pluck('post_id');
    //     $builder->whereIn('id', $postIds);
    // }

    // public function search(Builder $builder, $value): void
    // {
    //     $builder->where('title', 'LIKE', "%{$value}%")->orWhere('text', 'LIKE', "%{$value}%");
    // }

    public const PRICE_FROM = 'price_from';
    public const PRICE_TO = 'price_to';
    public const HIT = 'hit';
    public const NEWEST = 'newest';
    public const RECOMMEND = 'recommend';

    public function getCallbacks(): array
    {
        return [
            self::PRICE_FROM => [$this, 'priceFrom'],
            self::PRICE_TO => [$this, 'priceTo'],
            self::HIT => [$this, 'hit'],
            self::NEWEST => [$this, 'newest'],
            self::RECOMMEND => [$this, 'recommend']
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

    public function hit(Builder $builder, $value): void
    {
        $builder->where('hit', 1);
    }

    public function newest(Builder $builder, $value): void
    {
        $builder->where('newest', 1);
    }

    public function recommend(Builder $builder, $value): void
    {
        $builder->where('recommend', 1);
    }
}
