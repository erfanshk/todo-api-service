<?php

namespace App\Domains\Todo\Database\Models;

use App\Domains\Todo\Database\Attributes\TodoAttributes;
use App\Domains\Todo\Database\Factories\TodoFactory;
use App\Domains\Todo\Database\Queries\TodoQueries;
use App\Domains\Todo\Enums\TodoStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory, SoftDeletes, TodoQueries, TodoAttributes;

    protected $fillable = ['title', 'description', 'status', 'done_at'];

    protected $casts = [
        'status' => TodoStatusEnum::class,
        'done_at' => 'datetime',
    ];


    protected static function newFactory(): TodoFactory
    {
        return TodoFactory::new();
    }

}
