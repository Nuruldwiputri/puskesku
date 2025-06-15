<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Pasien = 'pasien';
}