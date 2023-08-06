<?php

namespace App\Enums;

/**
 * @method static find($id)
 */
enum PaymentMethod: string
{
    case ADVANCE_PAYMENT = 'ADVANCE_PAYMENT';
    case BANK_TRANSFER = 'BANK_TRANSFER';
    case CASH_PAYMENT = 'CASH_PAYMENT';
}
