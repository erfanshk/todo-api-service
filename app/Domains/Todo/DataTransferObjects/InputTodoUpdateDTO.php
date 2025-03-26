<?php

namespace App\Domains\Todo\DataTransferObjects;


use App\Domains\Todo\Enums\TodoStatusEnum;

readonly class InputTodoUpdateDTO
{
    public function __construct(
        private ?string $title,
        private ?string $description,
        private ?int $status
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getStatus(): TodoStatusEnum|null
    {
        return TodoStatusEnum::tryFrom($this->status);
    }


}
