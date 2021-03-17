<?php


namespace Refactoring\ChapterOne;


use Error;

class Statement
{
    private object $plays;
    private object $statementData;

    public function __construct(object $invoice, object $plays)
    {
        $this->plays         = $plays;
        $this->statementData = new \stdClass();

        $this->statementData->customer     = $invoice->customer;
        $this->statementData->performances = array_map(
            [$this, 'enrichPerformance'],
            $invoice->performances
        );
    }

    public function statement(): string
    {
        return $this->renderPlaneText($this->statementData);
    }

    private function enrichPerformance($performance)
    {
        $result         = $performance;
        $result->play   = $this->playFor($performance);
        $result->amount = $this->amountFor($performance);
        return $result;
    }

    private function renderPlaneText($statementData): string
    {
        $totalAmount = $this->totalAmount();

        $result = "Statement for {$statementData->customer}\n";

        foreach ($statementData->performances as $perf) {
            // print line for this order
            $result .= "{$perf->play->name}: {$this->usd(
                $perf->amount
                )} ({$perf->audience} seats)\n";
        }

        $result .= "Amount owed is {$this->usd($totalAmount)}\n";

        return $result . "You earner {$this->totalVolumeCredits()} credits\n";
    }

    private function totalAmount(): float
    {
        $result = 0;
        foreach ($this->statementData->performances as $perf) {
            $result += $perf->amount;
        }
        return $result;
    }

    private function totalVolumeCredits(): float
    {
        $result = 0;
        foreach ($this->statementData->performances as $perf) {
            $result += $this->volumeCreditsFor($perf);
        }
        return $result;
    }

    private function usd(float $value): string
    {
        return '$' . number_format($value / 100, 2);
    }

    private function playFor($perf): object
    {
        return $this->plays->{$perf->playID};
    }

    private function volumeCreditsFor($perf): float
    {
        $result = max($perf->audience - 30, 0);
        // add extra credit for every ten comedy attendees
        if ('comedy' === $perf->play->type) {
            $result += floor($perf->audience / 5);
        }
        return $result;
    }

    private function amountFor($perf)
    {
        switch ($perf->play->type) {
            case 'tragedy':
                $result = 40000;
                if ($perf->audience > 30) {
                    $result += 1000 * ($perf->audience - 30);
                }
                break;
            case 'comedy':
                $result = 30000;
                if ($perf->audience > 20) {
                    $result += 10000 + 500 * ($perf->audience - 20);
                }
                $result += 300 * $perf->audience;
                break;
            default:
                throw new Error("unknown type: {$perf->play->type}");
        }
        return $result;
    }
}