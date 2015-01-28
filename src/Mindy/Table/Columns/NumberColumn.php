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


class NumberColumn extends Column
{
    /**
     * @var int
     */
    public $decimals = 0;
    /**
     * @var string delimiter
     */
    public $decPoint = '.';
    /**
     * @var string
     */
    public $thousandsSep = ',';

    public function getValue($record)
    {
        $value = parent::getValue($record);
        return ($this->emptyValue && !$value) ? '' : number_format($value, $this->decimals, $this->decPoint, $this->thousandsSep);
    }
} 