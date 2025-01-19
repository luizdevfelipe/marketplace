<?php

namespace App\Enums;

enum AppEnvironmentEnum: string
{
    case DEVELOPMENT = 'local';
    case PRODUCTION = 'production';
}