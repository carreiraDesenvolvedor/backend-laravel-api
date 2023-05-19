<?php

namespace App\Enums;

enum ApiNewsEnum: string
{
    case NewsApi = 'news-api';
    case TheGuardian = 'the-guardian';
    case NewYorkTimes = 'new-york-times';
}
