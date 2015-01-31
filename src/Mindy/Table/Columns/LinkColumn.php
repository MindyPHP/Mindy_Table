<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 29/01/15 15:45
 */

namespace Mindy\Table\Columns;

use Closure;

class LinkColumn extends Column
{
    /**
     * @var string
     */
    public $template = "<a href='{url}' title='{value}'>{value}</a>";
    /**
     * @var Closure
     */
    public $route;

    /**
     * @param $record
     * @return string
     * @throws \Exception
     */
    public function getValue($record)
    {
        $value = parent::getValue($record);
        $url = $this->route->__invoke($record);
        return $url ? strtr($this->template, [
            '{value}' => $value,
            '{url}' => $url
        ]) : $value;
    }
}
