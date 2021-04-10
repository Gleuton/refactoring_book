<?php

namespace Tests\ChapterOne;

use Refactoring\ChapterOne\Statement;
use PHPUnit\Framework\TestCase;

class StatementTest extends TestCase
{
    private Statement $statement;

    protected function setUp(): void
    {
        $files           = new StatementLoadFiles();
        $this->statement = new Statement($files->invoices, $files->plays);
    }

    public function testCostumersMustReturnBigCo(): void
    {
        self::assertEquals('BigCo', $this->statement->customer);
    }

    public function testPerformancesMustReturnThreeItems(): void
    {
        self::assertCount(3, $this->statement->performances);
    }

    public function testTotalAmountMustReturn1730(): void
    {
        self::assertEquals(1730, $this->statement->totalAmount);
    }

    public function testTotalVolumeCreditsMustReturn47(): void
    {
        self::assertEquals(47, $this->statement->totalVolumeCredits);
    }
}
