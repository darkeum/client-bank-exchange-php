<?php

/*
* @name        ClientBankExchange
* @link        https://darkeum.ru/
* @copyright   Copyright (C) 2012-2022 ООО «ПРИС»
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      Komarov Ivan
*/

namespace Darkeum\ClientBankExchange\Model;

use Darkeum\ClientBankExchange\Component;

class FilterSection extends Component
{
    public static function fields()
    {
        return [
            'ДатаНачала',
            'ДатаКонца',
            'РасчСчет',
            'Документ',
        ];
    }
}
