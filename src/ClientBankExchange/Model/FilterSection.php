<?php

namespace AE\Tools1C\ClientBankExchange\Model;

use AE\Tools1C\ClientBankExchange\Component;

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
