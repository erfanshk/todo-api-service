<?php


namespace App\Domains\Shared\Database\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseRepository
{

    public string $resource;
    public Model $model;

    public function __construct(string $modelClass, string $resourceClass)
    {
        $this->model = new $modelClass;
        $this->resource = $resourceClass;
    }

    public function newQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->newQuery();
    }

    public function toResource(Model $model): array
    {
        return $this->resource::make($model)->resolve();
    }

    public function toCollection(Collection $collection): array
    {
        return $this->resource::collection($collection)->resolve();
    }

    public function getAll(): Collection
    {
        return $this->model->newQuery()->get();
    }

}
