# Validator for LARAVEL to validate BRAZILIAN DOCUMENTS

This library validate CPF, CNPJ, CNH, TÍTULO DE ELEITOR, NÚMERO DE IDENTIFICAÇÃO SOCIAL, CARTÃO NACIONAL DE SAÚDE, CERTIDÃO (NASCIMENTO/CASAMENTO/ÓBITO)  numbers

## Installation

Run the following command from you terminal:

 ```bash
 composer require "douglasresendemaciel/brazilian-documents-validator:@dev"
 ```

or add this to require section in your composer.json file:

 ```
 "douglasresendemaciel/brazilian-documents-validator"
 ```

then run ```composer update```

Once it is installed, you do not need anymore to register in the service provider, the package will be load automatically.

## Usage

* cnpj - Check if the CNPJ number is valid
```php
$this->validate($request, [
    'field_name' => 'required|cnpj',
]);
```

* cpf - Check if the CPF number is valid
```php
$this->validate($request, [
    'field_name' => 'required|cpf',
]);
```

* cnh - Check if the CNH number is valid
```php
$this->validate($request, [
    'field_name' => 'required|cnh',
]);
```

* título de eleitor - Check if the TÍTULO DE ELEITOR number is valid
```php
$this->validate($request, [
    'field_name' => 'required|titulo_eleitor',
]);
```

* número de identificação social - Check if the NÚMERO DE IDENTIFICAÇÃO SOCIAL number is valid
```php
$this->validate($request, [
    'field_name' => 'required|nis',
]);
```

* cartão nacional de saúde - Check if the CARTÃO NACIONAL DE SAÚDE number is valid
```php
$this->validate($request, [
    'field_name' => 'required|cns',
]);
```

* certidão - Check if the CERTIDÃO number is valid
```php
$this->validate($request, [
    'field_name' => 'required|certidao',
]);
```

OR you can use on RequestValidator files like this:
```php
'rules' => [
...
'field_name' => 'required|cpf',
...
```

Now is possible create fake document number from this packaged, you just need use the facade GenerateRandomDocument
```php
use DouglasResende\BrazilianDocumentsValidator\Facade\GenerateRandomDocument;

$cpf = GenerateRandomDocument::generateCPF();
$cnpj = GenerateRandomDocument::generateCNPJ();
$cnh = GenerateRandomDocument::generateCNH();
```

## Author

Douglas Resende: [http://www.douglasresende.com/](http://www.douglasresende.com/)

## License

[mit]: http://www.opensource.org/licenses/mit-license.php


## References

For more information read the official documentation at [https://laravel.com/docs/5.4/](https://laravel.com/docs/5.4/)
