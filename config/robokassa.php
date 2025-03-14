<?php

return [

    'login' => env('ROBOKASSA_LOGIN'), #  - логин
    'password1' => env('ROBOKASSA_PASSWORD1'), #  - пароль 1
    'password2' => env('ROBOKASSA_PASSWORD2'), #  - пароль 2
    'is_test' => env('ROBOKASSA_IS_TEST', true), #  - true|false
    'hashType' => env('ROBOKASSA_HASHTYPE', 'md5'), #  - md5|ripemd160|sha1|sha256|sha384|sha512

];
