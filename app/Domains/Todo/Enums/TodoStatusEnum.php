<?php

namespace App\Domains\Todo\Enums;


enum TodoStatusEnum: int
{
    case PENDING = 0;
    case IN_PROGRESS = 5;
    case DONE = 10;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::DONE => 'Done',
        };
    }
}
