<?php

namespace App\Domains\Todo\Database\Attributes;

use App\Domains\Todo\Enums\TodoStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait TodoAttributes
{
    public function isDeletable(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->status !== TodoStatusEnum::DONE
        );
    }
}
