<?php
namespace App\Enums;

enum TaskStatus: string
{
    case PENDING = 'Pending';
    case IN_PROGRESS = 'InProgress';
    case COMPLETED = 'Completed';
}

