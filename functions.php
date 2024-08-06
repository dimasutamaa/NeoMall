<?php

function random_password()
{
    $random_int = rand(100, 999);
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    $random_str = substr(str_shuffle($str_result), 0, 5);

    $random_password = $random_str . $random_int;

    return $random_password;
}
