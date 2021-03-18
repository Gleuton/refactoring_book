<?php

namespace Refactoring\ChapterOne;

class StatementRender
{
    private Statement $statementData;

    public function __construct(object $invoice, object $plays)
    {
        $this->statementData = new Statement($invoice, $plays);
    }

    public function renderPlainText(): string
    {
        $totalAmount = $this->statementData->totalAmount;

        $result = "Statement for {$this->statementData->customer}\n";

        foreach ($this->statementData->performances as $perf) {
            // print line for this order
            $result .= "{$perf->play->name}: {$this->usd(
                $perf->amount
                )} ({$perf->audience} seats)\n";
        }

        $result .= "Amount owed is {$this->usd($totalAmount)}\n";

        return $result . "You earner {$this->statementData->totalVolumeCredits} credits\n";
    }

    private function usd(float $value): string
    {
        return '$' . number_format($value / 100, 2);
    }
}