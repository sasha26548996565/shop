<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Support\Facades\App;

trait Translatable
{
    private string $defaultLocale = 'ru';
    private string $enLocale = 'en';

    public function __(string $originalFieldName): string
    {
        $currentLocale = App::getLocale() ?? $this->defaultLocale;

        $fieldName = $this->getFieldName($currentLocale, $originalFieldName);

        if(! in_array($fieldName, array_keys($this->attributes)))
            throw new \LogicException('not such attribute in model ' . get_class($this));

        return $this->$fieldName;
    }

    private function getFieldName(string $currentLocale, string $originalFieldName): string
    {
        if ($currentLocale == $this->enLocale)
            $fieldName = $originalFieldName . '_en';
        else
            $fieldName = $originalFieldName;

        return $fieldName;
    }
}
