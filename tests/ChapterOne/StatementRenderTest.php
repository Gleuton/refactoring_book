<?php

namespace Tests\ChapterOne;

use Refactoring\ChapterOne\StatementRender;
use PHPUnit\Framework\TestCase;

class StatementRenderTest extends TestCase
{
    private string $result = 'Statement for BigCo
Hamlet: $650.00 (55 seats)
As You Like It: $580.00 (35 seats)
Othello: $500.00 (40 seats)
Amount owed is $1,730.00
You earner 47 credits
';

    public function testStatementRenderReturnsPlainText(): void
    {
        $invoices_file = file_get_contents(
            __DIR__ . '/json/invoices.json'
        );
        $plays_file    = file_get_contents(
            __DIR__ . '/json/plays.json'
        );

        try {
            $invoices = json_decode(
                $invoices_file,
                false,
                512,
                JSON_THROW_ON_ERROR
            );

            $plays = json_decode(
                $plays_file,
                false,
                512,
                JSON_THROW_ON_ERROR
            );

            $text = (new StatementRender($invoices, $plays))->renderPlainText();
            self::assertEquals($text, $this->result);
        } catch (\JsonException $e) {
            echo $e->getMessage();
        }
    }
}
