<?php

namespace App\Concerns;

use Illuminate\Support\Str;

trait HasUUID
{
    // the method name must follow the initialize{TraitName} pattern.
    protected function initializeHasUUID(): void
    {
        $this->mergeFillable(['id']);
    }

    // the method name must follow the boot{TraitName} pattern.
    protected static function bootHasUUID(): void
    {
        static::creating(function (self $model) {
            $model->{$model->getKeyName()} ??= Str::orderedUuid();
        });
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
