<?php


namespace Refactoring\ChapterOne;


use Error;

class StatementRender
{
    private object $plays;
    private object $statementData;

    public function __construct(object $invoice, object $plays)
    {
        $this->plays         = $plays;
        $this->statementData = $this->createStatementData($invoice);
    }

    public function renderPlaneText(): string
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

    private function createStatementData($invoice): \stdClass
    {
        $data = new \stdClass();

        $data->customer     = $invoice->customer;
        $data->performances = array_map(
            [$this, 'enrichPerformance'],
            $invoice->performances
        );
        $data->totalAmount        = $this->totalAmount(
            $data
        );
        $data->totalVolumeCredits = $this->totalVolumeCredits(
            $data
        );

        return $data;
    }

    private function enrichPerformance($performance)
    {
        $result                = $performance;
        $result->play          = $this->playFor($performance);
        $result->amount        = $this->amountFor($performance);
        $result->volumeCredits = $this->volumeCreditsFor($performance);
        return $result;
    }

    private function totalAmount($data): float
    {
        $result = 0;
        foreach ($data->performances as $perf) {
            $result += $perf->amount;
        }
        return $result;
    }

    private function totalVolumeCredits($data): float
    {
        $result = 0;
        foreach ($data->performances as $perf) {
            $result += $perf->volumeCredits;
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