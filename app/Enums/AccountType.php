<?php
namespace App\Enums;

/**
 * @method static find($id)
 */
enum AccountType: string
{
    case BUSINESS = 'BUSINESS';
    case ADMINISTRATOR = 'ADMINISTRATOR';
}
