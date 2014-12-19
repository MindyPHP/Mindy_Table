<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 19/12/14 12:42
 */

namespace Mindy\Table\Columns;


use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;

abstract class Column
{
    use Configurator, Accessors;

    /**
     * @var string Column title
     */
    public $title;

    /**
     * @var string Column name
     */
    public $name;

    /**
     * @var \Mindy\Table\Table
     */
    public $table;

    /**
     * @var string
     */
    public $cellTemplate = '<td {html}>{prefix}{value}{postfix}</td>';

    /**
     * @var string
     */
    public $headCellTemplate = '<th {html}>{title}</th>';

    /**
     * @var array|string
     */
    public $html = [];

    /**
     * @var string
     */
    public $prefix = '';

    /**
     * @return string
     */
    public $postfix = '';

    /**
     * @var null|string
     */
    public $emptyValue = null;

    /**
     * @return bool
     */
    public $virtual = false;

    public function getTitle()
    {
        return $this->title ? $this->title : $this->name;
    }

    public function getHtmlAttributes()
    {
        if (is_array($this->html)) {
            $html = '';
            foreach ($this->html as $name => $value) {
                $html .= is_numeric($name) ? " $value" : " $name='$value'";
            }
            return $html;
        } else {
            return $this->html;
        }
    }

    public function renderHeadCell()
    {
        return strtr($this->headCellTemplate,[
            '{title}' => $this->getTitle(),
            '{html}' => $this->getHtmlAttributes()
        ]);
    }

    public function renderFootCell()
    {
        // @TODO
        return '';
    }

    public function getValue($record)
    {
        $value = '';
        if (!$this->virtual) {
            if (is_array($record) && isset($record[$this->name])) {
                $value = $record[$this->name];
            } elseif (is_object($record)) {
                $value = $record->{$this->name};
            }
        }
        return $value;
    }

    public function renderCell($record)
    {
        $value = $this->getValue($record);
        $empty = false;
        if (!$value) {
            $empty = $this->emptyValue;
        }
        return strtr($this->cellTemplate, [
            '{value}' => $empty ? $empty : $value,
            '{name}' => $this->name,
            '{prefix}' => $empty ? '' : $this->prefix,
            '{postfix}' => $empty ? '' : $this->postfix,
            '{html}' => $this->getHtmlAttributes()
        ]);
    }
} 