<?php

namespace App\Domains\Todo\DataTransferObjects;


use App\Domains\Todo\Enums\TodoStatusEnum;

readonly class InputTodoIndexDTO
{
    public function __construct(
        private ?string $query = null,
        private ?int    $status = 0,
        private ?int    $offset = 0,
        private ?int    $limit = 10
    )
    {
    }

    public function getQuery(): string|null
    {
        return $this->query;
    }


    public function getStatus(): TodoStatusEnum|null
    {
        return TodoStatusEnum::from($this->status);
    }

    public function getOffset(): int|null
    {
        return $this->offset;
    }

    public function getLimit(): int|null
    {
        return $this->limit;
    }
}
