<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskPriorityEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}
