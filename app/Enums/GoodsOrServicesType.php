<?php

namespace App\Enums;

/**
 * @method static find($id)
 */
enum GoodsOrServicesType: string
{
    case GOOD = 'GOOD';
    case SERVICE = 'SERVICE';
}
