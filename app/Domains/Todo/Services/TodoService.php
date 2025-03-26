<?php

namespace App\Domains\Todo\Services;


use App\Domains\Todo\Database\Repositories\TodoRepository;
use App\Domains\Todo\DataTransferObjects\InputTodoIndexDTO;
use App\Domains\Todo\DataTransferObjects\InputTodoStoreDTO;
use App\Domains\Todo\DataTransferObjects\InputTodoUpdateDTO;
use App\Domains\Todo\Exceptions\NotDeletableException;

readonly class TodoService
{

    public function __construct(private TodoRepository $repository)
    {

    }

    public function index(InputTodoIndexDTO $indexDTO): array
    {
        return $this->repository->toCollection(
            $this->repository->index($indexDTO)
        );
    }

    public function store(InputTodoStoreDTO $storeDTO): array
    {
        return $this->repository->toResource(
            $this->repository->create($storeDTO)
        );
    }
    public function update(string $id,InputTodoUpdateDTO $updateDTO): array
    {
        return $this->repository->toResource(
            $this->repository->update($id,$updateDTO)
        );
    }

    /**
     * @throws NotDeletableException
     */
    public function destroy(string $id): void
    {
        $this->repository->destroy($id);
    }
}
