<?php
include_once('Elements.php');

class Building
{
    private $a;
    private $b;
    private $c;
    private $d;
    public $width;
    public $height;

    const EARTH_RADIUS = 6371000;

    public function __construct($a, $b, $c, $d)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;

        $this->width = $this->getDistanceBetweenPoints(true);
        $this->height = $this->getDistanceBetweenPoints();
    }

    public function getDistanceBetweenPoints($horizontal = false)
    {
        $latitudeFrom = $horizontal ? $this->a->x : $this->c->x;
        $longitudeFrom = $horizontal ? $this->a->y : $this->c->y;
        $latitudeTo = $horizontal ? $this->c->x : $this->b->x;
        $longitudeTo = $horizontal ? $this->c->y : $this->b->y;

        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * self::EARTH_RADIUS;
    }

    private static function getWireLength($fullLength)
    {
        $length = $fullLength - 2 * Elements::CORNER_WIDTH - 2 * Elements::COLUMN_WIDTH - Elements::GATE_WIDTH;
        $count = 0;
        while ($length >= 0) {
            if ($length < Elements::WIRE_WIDTH + Elements::COLUMN_WIDTH) {
                $length = $length - Elements::WIRE_WIDTH;
            } else {
                $length = $length - (Elements::WIRE_WIDTH + Elements::COLUMN_WIDTH);
            }
            $count++;
        }
        $wire = 0;
        $column = 0;
        if ($count % 2 == 0) {
            $wire = $column = $count / 2;
        } else {
            $wire = round($count / 2);
            $column = floor($count / 2);
        }
        return [$wire, $column];
    }

    public function calculatePerimeter()
    {
        return ($this->width + $this->height) * 2;
    }

    public function calculateArea()
    {
        return $this->width * $this->height;
    }

    public function calculateBuildingPrice()
    {
        [$horizontalWire, $horizontalColumn] = self::getWireLength($this->width);
        [$verticalWire, $verticalColumn] = self::getWireLength($this->height);

        $basePrice = 4 * (Elements::CORNER_PRICE + 2 * Elements::COLUMN_PRICE + Elements::GATE_PRICE);
        return $basePrice + 2 * ($horizontalWire + $verticalWire) * Elements::WIRE_PRICE + 2 * ($horizontalColumn + $verticalColumn) * Elements::COLUMN_PRICE;
    }
}
