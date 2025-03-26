<?php

namespace App\Domains\Todo\Exceptions;


class NotDeletableException extends \Exception {
    protected $code = 400;
}
