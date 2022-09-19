# 1CClientBankExchange parser
Парсер формата обмена данными 1CClientBankExchange (версии 1.03)

Основан на репозитории https://github.com/kilylabs/client-bank-exchange-php

Установка
------------

Рекомендуемый способ установки через
[Composer](http://getcomposer.org):

```
$ composer require ae-soft/client-bank-exchange-php
```

Использование
-----

Пример кода

```php
<?php

use Darkeum\ClientBankExchange\Parser;

require('vendor/autoload.php');

$p = new Parser('tests/resources/huge.txt');
var_dump($p->general); // general info
var_dump($p->filter); // selection settings
var_dump($p->remainings); // to see bank account remainings
foreach($p->documents as $d) {
    echo $d['type'], " => "; // document type
    echo $d->{'Номер'}; // some fields
    echo "\n";
}
```

