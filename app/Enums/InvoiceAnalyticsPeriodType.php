<?php

namespace App\Enums;

/**
 * @method static find($id)
 */
enum InvoiceAnalyticsPeriodType: string
{
    case DAILY = 'DAILY';
    case WEEKLY = 'WEEKLY';
    case MONTHLY = 'MONTHLY';
    case YEARLY = 'YEARLY';
}
