# Validator for LARAVEL to validate CPF, CNPJ and CNH

This library validate CPF, CNPJ and CNH numbers

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
    'cnpj' => 'required|cnpj',
]);
```

* cpf - Check if the CPF number is valid
```php
$this->validate($request, [
    'cpf' => 'required|cpf',
]);
```

* cnh - Check if the CNH number is valid
```php
$this->validate($request, [
    'cnh' => 'required|cnh',
]);
```

OR you can use on RequestValidator files like this:
```php
'rules' => [
...
'cpf' => 'required|cpf',
...
```

Now is possible create fake document number from this packaged, you just need use the facade 

## Author

Douglas Resende: [http://www.douglasresende.com/](http://www.douglasresende.com/)

## License

[mit]: http://www.opensource.org/licenses/mit-license.php


## References

For more information read the official documentation at [https://laravel.com/docs/5.4/](https://laravel.com/docs/5.4/)