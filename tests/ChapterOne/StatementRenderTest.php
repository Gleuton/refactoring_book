<?php

namespace Tests\ChapterOne;

use PHPUnit\Framework\TestCase;
use Refactoring\ChapterOne\StatementRender;

class StatementRenderTest extends TestCase
{
    private StatementLoadFiles $files;
    private string $resultPlainText = 'Statement for BigCo
Hamlet: $650.00 (55 seats)
As You Like It: $580.00 (35 seats)
Othello: $500.00 (40 seats)
Amount owed is $1,730.00
You earner 47 credits
';
    protected function setUp(): void
    {
        $this->files = new StatementLoadFiles();
    }

    public function testStatementRenderReturnsPlainText(): void
    {
        $text = (new StatementRender($this->files->invoices, $this->files->plays))
            ->renderPlainText();
        self::assertEquals($text, $this->resultPlainText);
    }
}
