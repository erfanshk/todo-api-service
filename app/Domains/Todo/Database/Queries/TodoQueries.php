<?php

namespace App\Domains\Todo\Database\Queries;

use App\Domains\Todo\DataTransferObjects\InputTodoIndexDTO;
use Illuminate\Database\Eloquent\Builder;

trait TodoQueries
{
    public function scopeFilter(Builder $builder, InputTodoIndexDTO $indexDTO): Builder
    {
        return $builder
            ->when(!empty($indexDTO->getQuery()), fn($q) => $q
                ->where(['title', 'LIKE', '%' . $indexDTO->getQuery() . '%'])
                ->orWhere(['description', 'LIKE', '%' . $indexDTO->getQuery() . '%']))
            ->when(!empty($indexDTO->getStatus()), fn($q) => $q->where('status', $indexDTO->getStatus()))
            ->offset($indexDTO->getOffset())
            ->limit($indexDTO->getLimit())
            ->orderByDesc('created_at');
    }
}
