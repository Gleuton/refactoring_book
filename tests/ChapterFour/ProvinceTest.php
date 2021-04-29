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
}
