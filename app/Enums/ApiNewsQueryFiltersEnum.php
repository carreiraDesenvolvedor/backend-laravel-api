<?php

namespace App\Enums;

enum ApiNewsQueryFiltersEnum: string
{
    case keyword = 'keyword';
    case fromDate = 'from-date';
    case source = 'source';

    case pageSize = 'page-size';

    case currentPage = 'current-page';
}
