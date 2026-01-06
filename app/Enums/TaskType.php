<?php

namespace App\Enums;
enum TaskType: string
{
    case FEATURE = 'feature';
    case BUG = 'bug';
    case REFACTOR = 'refactor';
    case IDEA = 'idea';
    case LEARNING = 'learning';
}