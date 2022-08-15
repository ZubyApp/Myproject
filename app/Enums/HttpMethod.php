<?php

declare(strict_types = 1);

namespace App\Enums;

enum HttpMethod
{
    case Get  = 'get';
    case Post = 'post';
    case Put  = 'put';
    case Head = 'Head';
}