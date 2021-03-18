<?php

namespace Tests\ChapterOne;

use PHPUnit\Framework\TestCase;
use Refactoring\ChapterOne\StatementRender;

class StatementRenderTest extends TestCase
{
    private StatementLoadFiles $files;
    private string $resultPlainText = "Statement for BigCo\n" .
    "Hamlet: $650.00 (55 seats)\n" .
    "As You Like It: $580.00 (35 seats)\n" .
    "Othello: $500.00 (40 seats)\n" .
    "Amount owed is $1,730.00\n" .
    "You earner 47 credits\n";

    private string $resultHtml = '<h1>Statement for BigCo</h1>' .
    '<table>' .
    '<tr><th>Play</th><th>Seats</th><th>Cost</th></tr>' .
    '<tr><td>Hamlet</td><td>55</td><td>$650.00</td></tr>' .
    '<tr><td>As You Like It</td><td>35</td><td>$580.00</td></tr>' .
    '<tr><td>Othello</td><td>40</td><td>$500.00</td></tr>' .
    '</table>' .
    '<p>Amount owed is $1,730.00</p>' .
    '<p>You earner 47 credits</p>';

    protected function setUp(): void
    {
        $this->files = new StatementLoadFiles();
    }

    public function testStatementRenderReturnsPlainText(): void
    {
        $text = (new StatementRender(
            $this->files->invoices,
            $this->files->plays
        ))->renderPlainText();

        self::assertEquals($this->resultPlainText, $text);
    }

    public function testStatementRenderReturnsHtml(): void
    {
        $html = (new StatementRender(
            $this->files->invoices,
            $this->files->plays
        ))->renderHtml();

        self::assertEquals($this->resultHtml, $html);
    }
}
