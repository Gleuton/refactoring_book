<?php

namespace Tests\ChapterFour;

use PHPUnit\Framework\TestCase;
use Refactoring\ChapterFour\Province;

class NoProducersTest extends TestCase
{
    private Province $province;

    protected function setUp(): void
    {
        $data = new \stdClass();
        $data->name   = "No Producers";
        $data->demand = 30;
        $data->price  = 20;
        $data->producers = [];
        $this->province = new Province($data);
    }

    public function testShortFall(): void
    {
        self::assertEquals(30, $this->province->shotFall());
    }

    public function testProfit(): void
    {
        self::assertEquals(0, $this->province->profit());
    }
}
