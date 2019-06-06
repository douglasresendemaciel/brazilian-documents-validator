<?php

namespace DouglasResende\BrazilianDocumentsValidator\Helpers;

use Illuminate\Support\Facades\Facade;

class GenerateRandomDocuments extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'generaterandomdocuments';
    }
}