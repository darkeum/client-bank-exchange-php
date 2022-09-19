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

class Parser implements \ArrayAccess
{
    protected $encoding;
    protected $result;

    public function __construct($file, $encoding = 'cp1251')
    {
        $this->encoding = $encoding;
        $this->result = $this->parse_file($file);
    }

    protected function defaultResult()
    {
        return [
            'general' => [],
            'filter' => [],
            'remainings' => [],
            'documents' => [],
        ];
    }

    public function parse_file($path)
    {
        if (!file_exists($path)) {
            throw new Exception('File does not exists: ' . $path);
        }

        return $this->parse(file_get_contents($path));
    }

    public function parse($content)
    {
        if ($this->encoding) {
            $content = iconv($this->encoding, 'UTF-8', $content);
        }

        $result = $this->defaultResult();

        $header = '1CClientBankExchange';
        if ($header == substr($content, 0, strlen($header))) {
            $result['general'] = $this->general($content);
            $result['filter'] = $this->filter($content);
            $result['remainings'] = $this->remainings($content);
            $result['documents'] = $this->documents($content);
        } else {
            throw new Exception('Wrong format: 1CClientBankExchange not found');
        }

        return $result;
    }

    public function general($content)
    {
        $result = [];
        foreach (Model\GeneralSection::fields() as $key) {
            if (preg_match("/^{$key}=(.+)/um", $content, $matches)) {
                $result[$key] = trim($matches[1]);
            } else {
                $result[$key] = null;
            }
        }

        return new Model\GeneralSection($result);
    }

    public function filter($content)
    {
        $result = [];
        foreach (Model\FilterSection::fields() as $key) {
            if (preg_match("/^{$key}=(.+)/um", $content, $matches)) {
                $result[$key] = trim($matches[1]);
            } else {
                $result[$key] = null;
            }
        }

        return new Model\FilterSection($result);
    }

    public function remainings($content)
    {
        $result = [];

        if (preg_match('/СекцияРасчСчет([\s\S]*?)\sКонецРасчСчет/um', $content, $matches)) {
            $part = $matches[1];
            foreach (array_filter(preg_split('/\r?\n/um', $part)) as $line) {
                list($key, $val) = explode('=', trim($line), 2);
                $result[$key] = $val;
            }
        }

        return new Model\RemainingsSection($result);
    }

    public function documents($content)
    {
        $result = [];

        if (preg_match_all('/СекцияДокумент=(.*)\s([\s\S]*?)\sКонецДокумента/um', $content, $matches)) {
            foreach ($matches[0] as $match) {
                $doc = [];
                $part = $match;
                foreach (array_filter(preg_split('/\r?\n/um', $part)) as $line) {
                    @list($key, $val) = explode('=', trim($line), 2);
                    $doc[$key] = $val;
                }

                $type = isset($doc['СекцияДокумент']) ? $doc['СекцияДокумент'] : null;
                unset($doc['СекцияДокумент']);
                unset($doc['КонецДокумента']);

                $result[] = new Model\DocumentSection($type, $doc);
            }
        }

        return $result;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->result[] = $value;
        } else {
            $this->result[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->result[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->result[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->result[$offset]) ? $this->result[$offset] : null;
    }

    public function __get($name)
    {
        if (isset($this->result[$name])) {
            return $this->result[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );

        return;
    }
}
