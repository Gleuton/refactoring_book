<?php

namespace Tests\ChapterFour;

use Refactoring\ChapterFour\Province;
use PHPUnit\Framework\TestCase;

class ProvinceTest extends TestCase
{
    private Province $province;

    protected function setUp(): void
    {
        $this->province = new Province(new SampleProvinceData());
    }

    public function testShortFall(): void
    {
        self::assertEquals(5, $this->province->shotFall());
    }

    public function testProfit(): void
    {
        self::assertEquals(230, $this->province->profit());
    }

    public function testChangeProduction(): void
    {
        $this->province->getProducers()[0]->setProduction(20);
        self::assertEquals(-6, $this->province->shotFall());
        self::assertEquals(292, $this->province->profit());
    }

    public function testZeroDemand(): void
    {
        $this->province->setDemand(0);
        self::assertEquals(-25, $this->province->shotFall());
        self::assertEquals(0, $this->province->profit());
    }

    public function testNegativeDemand(): void
    {
        $this->province->setDemand(-1);
        self::assertEquals(-26, $this->province->shotFall());
        self::assertEquals(-10, $this->province->profit());
    }
}
