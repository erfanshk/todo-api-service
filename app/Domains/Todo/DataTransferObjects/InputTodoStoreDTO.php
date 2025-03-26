<?php

namespace App\Domains\Todo\DataTransferObjects;


use App\Domains\Todo\Enums\TodoStatusEnum;

readonly class InputTodoStoreDTO
{
    public function __construct(
        private string $title,
        private string $description,
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


}
