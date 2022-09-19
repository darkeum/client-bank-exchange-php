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

class RemainingsSection extends Component
{
    public static function fields()
    {
        return [
            'ДатаНачала',
            'ДатаКонца',
            'РасчСчет',
            'НачальныйОстаток',
            'ВсегоПоступило',
            'ВсегоСписано',
            'КонечныйОстаток',
        ];
    }

    public function __construct($data = [])
    {
        parent::__construct($data);

        foreach (['ДатаНачала', 'ДатаКонца'] as $k) {
            if ($this->data[$k]) {
                $this->data[$k] = $this->toDate($this->data[$k]);
            }
        }

        foreach (['НачальныйОстаток', 'ВсегоПоступило', 'ВсегоСписано', 'КонечныйОстаток'] as $k) {
            if ($this->data[$k]) {
                $this->data[$k] = $this->toFloat($this->data[$k]);
            }
        }
    }
}
