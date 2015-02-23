<?php

namespace Mindy\Table\Columns;

use Closure;

/**
 * Class LinkColumn
 * @package Mindy\Table
 */
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
