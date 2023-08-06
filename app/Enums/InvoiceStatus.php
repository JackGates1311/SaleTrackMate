<?php

namespace App\Enums;

/**
 * @method static find($id)
 */
enum InvoiceStatus: string
{
    case STAGING = 'STAGING';
    case SENT = 'SENT';
    case CANCELLED = 'CANCELLED';
}
