<?php

namespace DouglasResende\BrazilianDocumentsValidator\Facade;

use Illuminate\Support\Facades\Facade;

class GenerateRandomDocument extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'generaterandomdocument';
    }
}