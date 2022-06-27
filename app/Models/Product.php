<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Filterable;
use DebugBar\DebugBar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $guarded = [];

    public function category(): Relation
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getTotalPrice(int $count): float
    {
        return $this->price * $count;
    }

    public function hit(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value == "on" ? 1 : 0
        );
    }

    public function recommend(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value == "on" ? 1 : 0
        );
    }

    public function newest(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value == "on" ? 1 : 0
        );
    }

    public function getLabels(): array
    {
        return [
            'hit' => 'Хит',
            'newest' => 'Новинка',
            'recommend' => 'Рекомендованные'
        ];
    }

    public function issetLabel(string $labelName): bool
    {
        return $this[$labelName] == 1;
    }

    public function disableLabel(array $params): array
    {
        foreach ($this->getLabels() as $field => $name)
        {
            if (! isset($params[$field]))
            {
                $params[$field] = 0;
            }
        }

        return $params;
    }

    public function isAvailable(): bool
    {
        return $this->count > 0;
    }
}
