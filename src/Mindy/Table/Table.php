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
 * @date 19/12/14 12:38
 */

namespace Mindy\Table;


use Mindy\Helper\Creator;
use Mindy\Helper\Traits\Accessors;
use Mindy\Helper\Traits\Configurator;
use Mindy\Orm\QuerySet;

class Table
{
    use Configurator, Accessors;

    /**
     * @var \Mindy\Orm|QuerySet|array
     */
    public $data = [];

    /**
     * @var array
     */
    public $html = [];

    /**
     * @var string
     */
    public $template = '<table {html}>{caption}{header}{footer}{body}</table>';

    /**
     * @var \Mindy\Table\Columns\Column[]
     */
    protected $_columns = null;

    /**
     * @var string Table caption
     */
    public $caption = '';

    public $enableHeader = true;
    public $enableFooter = false;

    public function getColumns()
    {
        return [];
    }

    public function __construct($data, array $config = [])
    {
        $this->data = $data;
        $this->configure($config);
        $this->init();
    }

    public function init()
    {

    }

    public function getInitColumns()
    {
        if (is_null($this->_columns)) {
            $this->_columns = [];

            foreach($this->getColumns() as $name=>$config) {
                if (!is_array($config)) {
                    $config = ['class' => $config];
                }

                $this->_columns[$name] = Creator::createObject(array_merge([
                    'name' => $name,
                    'table' => $this,
                ], $config));
            }
        }

        return $this->_columns;
    }


    public function render()
    {
        return strtr($this->template, [
            '{html}' => $this->getHtmlAttributes(),
            '{caption}' => $this->renderCaption(),
            '{header}' => $this->renderHeader(),
            '{footer}' => $this->renderFooter(),
            '{body}' => $this->renderBody()
        ]);
    }

    public function renderHeader()
    {
        $header = '';
        if ($this->enableHeader) {
            foreach ($this->getInitColumns() as $column) {
                $header .= $column->renderHeadCell();
            }
            return strtr('<thead>{header}</thead>', [
                '{header}' => $header
            ]);
        }
        return $header;
    }

    public function renderFooter()
    {
        $footer = '';
        if ($this->enableFooter) {
            foreach ($this->getInitColumns() as $column) {
                $footer .= $column->renderFootCell();
            }
            return strtr('<tfoot>{footer}</tfoot>', [
                '{footer}' => $footer
            ]);
        }
        return $footer;
    }

    public function renderBody()
    {
        $body = '';
        $data = $this->getData();
        foreach ($data as $item) {
            foreach ($this->getInitColumns() as $column) {
                $body .= $column->renderCell($item);
            }
        }
        return strtr('<tbody>{body}</tbody>', [
            '{body}' => $body
        ]);
    }

    public function renderCaption()
    {
        if ($this->caption) {
            return strtr('<caption>{caption}</caption>',[
                '{caption}' => $this->caption
            ]);
        }
        return '';
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

    public function __toString()
    {
        return (string)$this->render();
    }

    public function getData()
    {
        // @TODO: pager
        if (is_a($this->data, QuerySet::className())) {
            return $this->data->all();
        } else {
            return $this->data;
        }
    }
}