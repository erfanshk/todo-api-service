<?php

namespace App\Domains\Todo\Database\Repositories;


use App\Domains\Shared\Database\Repositories\BaseRepository;
use App\Domains\Todo\Database\Models\Todo;
use App\Domains\Todo\DataTransferObjects\InputTodoIndexDTO;
use App\Domains\Todo\DataTransferObjects\InputTodoStoreDTO;
use App\Domains\Todo\DataTransferObjects\InputTodoUpdateDTO;
use App\Domains\Todo\Enums\TodoStatusEnum;
use App\Domains\Todo\Exceptions\NotDeletableException;
use App\Domains\Todo\Http\Resources\TodoResource;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Todo::class, TodoResource::class);
    }

    public function index(InputTodoIndexDTO $indexDTO): Collection
    {
        return $this
            ->newQuery()
            ->filter($indexDTO)
            ->get();
    }
    public function show(string $id): Todo
    {
        return $this
            ->newQuery()
            ->findOrFail($id);
    }

    public function create(InputTodoStoreDTO $storeDTO): Todo
    {
        return $this
            ->newQuery()
            ->create([
                'title' => $storeDTO->getTitle(),
                'description' => $storeDTO->getDescription(),
                'status' => TodoStatusEnum::PENDING
            ]);
    }

    public function update(string $id, InputTodoUpdateDTO $updateDTO): Todo
    {
        $model = $this
            ->newQuery()
            ->findOrFail($id);

        $this
            ->newQuery()
            ->whereKey($id)
            ->update([
                'title' => $updateDTO->getTitle() ?? $model->title,
                'description' => $updateDTO->getDescription() ?? $model->description,
                'status' => $updateDTO->getStatus() ?? $model->status,
                'done_at' => $model->done_at === null && $updateDTO->getStatus() === TodoStatusEnum::DONE ? now() : null
            ]);
        return $this->newQuery()->find($id);
    }

    /**
     * @throws NotDeletableException
     */
    public function destroy(string $id): bool
    {
        $model = $this
            ->newQuery()
            ->findOrFail($id);

        if (!$model->isDeletable) throw new NotDeletableException('You cannot delete this todo.');

        return $this->newQuery()->whereKey($id)->delete();
    }
}
