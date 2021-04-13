<?php


namespace Tests\ChapterFour;

use StdClass;

class SampleProvinceData
{
    public string $name;
    public array $producers;
    public int $demand;
    public float $price;

    public function __construct()
    {
        $this->name   = "Asia";
        $this->demand = 30;
        $this->price  = 20;
        $this->producers = [
          $this->producer('Byzantium', 10, 9),
          $this->producer('Attalia', 12, 10),
          $this->producer('Sinope', 10, 6)
        ];
    }

    private function producer(string $name, int $cost, int $production): StdClass
    {
        $producer             = new StdClass();
        $producer->name       = $name;
        $producer->cost       = $cost;
        $producer->production = $production;
        return $producer;
    }
}