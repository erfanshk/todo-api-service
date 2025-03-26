<?php

namespace App\Domains\Todo\Http\Controllers;

use App\Domains\Shared\Http\Controllers\BaseController;
use App\Domains\Todo\DataTransferObjects\InputTodoIndexDTO;
use App\Domains\Todo\DataTransferObjects\InputTodoStoreDTO;
use App\Domains\Todo\DataTransferObjects\InputTodoUpdateDTO;
use App\Domains\Todo\Http\Requests\IndexRequest;
use App\Domains\Todo\Http\Requests\StoreRequest;
use App\Domains\Todo\Http\Requests\UpdateRequest;
use App\Domains\Todo\Services\TodoService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TodoController extends BaseController
{
    public function __construct(private readonly TodoService $service)
    {

    }

    public function index(IndexRequest $request): JsonResponse
    {
        $result = $this->tryCatch(fn() => $this->service->index(new InputTodoIndexDTO(...$request->validated())));


        if ($result['status'] === false) {
            return $this->responseException($result['exception']);
        }

        return $this
            ->setData($result['result'])
            ->respond();
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->tryCatch(fn() => $this->service->store(new InputTodoStoreDTO(...$request->validated())));

        if ($result['status'] === false) {
            return $this->responseException($result['exception']);
        }

        return $this
            ->setData($result['result'])
            ->setStatus(ResponseAlias::HTTP_CREATED)
            ->respond();
    }

    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        $result = $this->tryCatch(fn() => $this->service->update($id, new InputTodoUpdateDTO(...$request->validated())));

        if ($result['status'] === false) {
            return $this->responseException($result['exception']);
        }

        return $this
            ->setData($result['result'])
            ->respond();
    }

    public function destroy(string $id): JsonResponse
    {
        $result = $this->tryCatch(fn() => $this->service->destroy($id));

        if ($result['status'] === false) {
            return $this->responseException($result['exception']);
        }

        return $this
            ->setStatus(ResponseAlias::HTTP_NO_CONTENT)
            ->setMessage('Todo Deleted Successfully')
            ->respond();
    }
}
