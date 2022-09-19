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

class GeneralSection extends Component
{
    public static function fields()
    {
        return [
            'ВерсияФормата',
            'Кодировка',
            'Отправитель',
            'Получатель',
            'ДатаСоздания',
            'ВремяСоздания',
        ];
    }

    public function __construct($data = [])
    {
        parent::__construct($data);
        if ($this->data['ДатаСоздания']) {
            $this->data['ДатаСоздания'] = $this->toDate($this->data['ДатаСоздания']);
        }
        if ($this->data['ВремяСоздания']) {
            $this->data['ВремяСоздания'] = $this->toTime($this->data['ВремяСоздания']);
        }
    }
}
