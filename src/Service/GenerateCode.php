<?php
namespace App\Service;
class GenerateCode{

    public static function code($n = 5)
    {
        $str = "";

        for ($i = 0; $i < $n; $i++)
        {
            $str .= chr(rand(0,25) + 65);
        }

        return $str;
    }

    public static function matricule()
    {
        return rand(100,1000);;
    }
}