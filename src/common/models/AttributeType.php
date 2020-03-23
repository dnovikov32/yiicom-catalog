<?php

namespace yiicom\catalog\common\models;

interface AttributeType
{
    const TYPE_CHECKBOX = 1;
    const TYPE_INT = 2;
    const TYPE_STR = 3;
    const TYPE_SELECT = 4;

    /**
     * Returns attribute types list
     * @return array
     */
    public function typesList(): array;
}