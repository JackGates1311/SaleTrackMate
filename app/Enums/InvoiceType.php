<?php

namespace App\Enums;

/**
 * @method static find($id)
 */
enum InvoiceType: string
{
    case INVOICE = 'INVOICE';
    case PROFORMA = 'PROFORMA';
}
