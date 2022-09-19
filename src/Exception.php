<?php

/*
* @name        ClientBankExchange
* @link        https://darkeum.ru/
* @copyright   Copyright (C) 2012-2022 ООО «ПРИС»
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      Komarov Ivan
*/

namespace Darkeum\ClientBankExchange;

class Exception extends \Exception
{
    public function __construct($msg = '', $code = 0, $previous = null)
    {
        if (is_array($code)) {
            $msg = str_replace(array_keys($code), array_values($code), $msg);
            $code = 0;
        }

        parent::__construct($msg, $code, $previous);
    }
}
