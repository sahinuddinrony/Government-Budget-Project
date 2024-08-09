<?php

namespace App\Helpers;

class NumberHelper
{
    public static function toBangla($number)
    {
        $eng = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bng = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace($eng, $bng, $number);
    }
}
 