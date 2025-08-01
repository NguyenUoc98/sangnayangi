<?php
/**
 * Created by PhpStorm.
 * Filename: OrderDetailStatus.php
 * User: Nguyễn Văn Ước
 * Date: 31/07/2022
 * Time: 18:19
 */

namespace App\Enums;

enum OrderDetailStatus: string
{
    case NEW = 'new_order';
    case DONE = 'done';
    case FAILED = 'failed';
}
