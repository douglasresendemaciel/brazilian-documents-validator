<?php

namespace DouglasResende\BrazilianDocumentsValidator;

use DouglasResende\BrazilianDocumentsValidator\Helpers\GenerateRandomDocument;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class BrazilianDocumentsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'documents');

        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            $messages += [
                'cnh' => trans('documents::validator.cnh'),
                'cnpj' => trans('documents::validator.cnpj'),
                'cpf' => trans('documents::validator.cpf'),
                'titulo_eleitor' => trans('documents::validator.titulo_eleitor'),
                'nis' => trans('documents::validator.nis'),
                'cns' => trans('documents::validator.cns'),
                'certidao' => trans('documents::validator.certidao'),
            ];
            return new Validator($translator, $data, $rules, $messages, $customAttributes);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('generaterandomdocument', function () {
            return new GenerateRandomDocument();
        });
    }
}
