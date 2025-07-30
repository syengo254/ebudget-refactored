<?php

namespace App\Enums;

enum StockUpdateType: string
{
    case ADD = 'add';
    case REMOVE = 'remove';
}
