<?php

namespace App\Domains\Todo\Http\Requests;

use App\Domains\Todo\Enums\TodoStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::in(TodoStatusEnum::cases())]
        ];
    }
}
