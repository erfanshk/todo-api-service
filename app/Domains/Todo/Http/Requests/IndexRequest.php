<?php

namespace App\Domains\Todo\Http\Requests;

use App\Domains\Todo\Enums\TodoStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'query' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(TodoStatusEnum::cases())],
            'offset' => ['nullable', 'numeric'],
            'limit' => ['nullable', 'numeric']
        ];
    }
}
