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

    public function renderHtml(): string
    {
        $totalAmount = $this->statementData->totalAmount;

        $result = "<h1>Statement for {$this->statementData->customer}</h1>";
        $result .= "<table>";
        $result .= "<tr><th>Play</th><th>Seats</th><th>Cost</th></tr>";
        foreach ($this->statementData->performances as $perf) {
            $result .='<tr>';
            $result .="<td>{$perf->play->name}</td>";
            $result .="<td>{$perf->audience}</td>";
            $result .="<td>{$this->usd($perf->amount)}</td>";
            $result .='</tr>';
        }
        $result .= "</table>";
        $result .= "<p>Amount owed is {$this->usd($totalAmount)}</p>";

        return $result . "<p>You earner {$this->statementData->totalVolumeCredits} credits</p>";
    }

    private function usd(float $value): string
    {
        return '$' . number_format($value, 2);
    }
}