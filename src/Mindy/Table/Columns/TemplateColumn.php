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
 * @date 19/12/14 13:24
 */

namespace Mindy\Table\Columns;


use Mindy\Utils\RenderTrait;

class TemplateColumn extends Column
{
    use RenderTrait;
    /**
     * @var string template path
     */
    public $template;
    /**
     * @var array extra data for template rendering
     */
    public $extra = [];

    public function getValue($record)
    {
        return self::renderTemplate($this->template, array_merge([
            'value' => parent::getValue($record),
            'record' => $record,
            'table' => $this->table
        ], $this->extra));
    }
}