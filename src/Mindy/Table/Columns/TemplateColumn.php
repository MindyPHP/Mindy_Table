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

    public $template;

    public function getValue($record)
    {
        $value = parent::getValue($record);

        return $this->renderTemplate($this->template, [
            'value' => $value,
            'record' => $record,
            'table' => $this->table
        ]);
    }
}