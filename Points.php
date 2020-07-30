<?php

class Points
{
    public $x = 0;
    public $y = 0;

    public function __construct($a, $b)
    {
        $this->x = $a;
        $this->y = $b;
    }

    public function validateLatLong()
    {
        return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $this->x . ',' . $this->y);
    }
}