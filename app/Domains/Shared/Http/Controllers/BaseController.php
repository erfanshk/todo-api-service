<?php

namespace App\Domains\Shared\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    private int $status = Response::HTTP_OK;

    private array $array = [];

    public function setResponseArray(array $array): self
    {
        $this->array = $array;

        return $this;
    }


    public function setData(mixed $data): self
    {
        $this->array['data'] = $data;

        return $this;
    }


    public function setMessage(string $message): self
    {
        $this->array['message'] = $message;

        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function respond(): JsonResponse
    {
        return new JsonResponse(
            data: empty($this->array) ? ['status' => true] : $this->array,
            status: empty($this->status) ? Response::HTTP_OK : $this->status
        );
    }

    public function responseException(\Exception $exception): JsonResponse
    {
        $status = (int)$exception->getCode();
        if ($status < 100 || $status >= 600) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        return $this
            ->setResponseArray([
                'message' => $exception->getMessage(),
                'trace' => App::environment() === 'local' ? $exception->getTrace() : '',
            ])
            ->setStatus($status)
            ->respond();

    }

    public function respondCreated(): JsonResponse
    {
        return $this
            ->setMessage('Created')
            ->setStatus(Response::HTTP_CREATED)
            ->respond();
    }

    public function respondOk($message = 'Ok'): JsonResponse
    {
        return $this
            ->setMessage($message)
            ->setStatus(Response::HTTP_OK)
            ->respond();
    }

    public function tryCatch(\Closure $callback): array
    {
        DB::beginTransaction();
        try {
            $result = $callback();
            DB::commit();
            return ['status' => true, 'result' => $result];
        } catch (\Exception $exception) {
            DB::rollBack();
            return ['status' => false, 'exception' => $exception];

        }
    }
}
