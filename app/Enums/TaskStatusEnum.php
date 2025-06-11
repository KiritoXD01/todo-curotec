<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatusEnum: string
{
    case ALL = 'all';
    case PENDING = 'pending';
    case COMPLETED = 'completed';
}
