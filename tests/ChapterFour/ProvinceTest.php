<?php

namespace Tests\ChapterFour;

use Refactoring\ChapterFour\Province;
use PHPUnit\Framework\TestCase;

class ProvinceTest extends TestCase
{
    public function testShortFall(): void
    {
        $province = new Province(new SampleProvinceData());
        self::assertEquals(5, $province->shotFall());
    }
}
