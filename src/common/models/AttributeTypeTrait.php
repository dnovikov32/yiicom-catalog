<?php

namespace yiicom\catalog\common\models;

trait AttributeTypeTrait 
{
    /**
     * Returns attribute types list
     * @return array
     */
    public function typesList() : array
    {
        return [
            static::TYPE_CHECKBOX => 'Флажок',
            static::TYPE_INT => 'Число',
            static::TYPE_STR => 'Текст',
            static::TYPE_SELECT => 'Выпадающий список',
        ];
    }
    
}
