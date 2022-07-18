<?php

declare(strict_types = 1);

namespace App\Exceptions\Container;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}