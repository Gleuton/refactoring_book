<?php


namespace Refactoring\ChapterOne;


use Error;

class Statement
{
    public string $customer;
    public array $performances;
    public float $totalAmount;
    public int $totalVolumeCredits;
    private object $plays;

    public function __construct(object $invoice, object $plays)
    {
        $this->plays         = $plays;
        $this->customer           = $invoice->customer;
        $this->performances       = array_map(
            [$this, 'enrichPerformance'],
            $invoice->performances
        );
        $this->totalAmount        = $this->totalAmount();
        $this->totalVolumeCredits = $this->totalVolumeCredits();
    }

    private function totalAmount(): float
    {
        $result = 0;
        foreach ($this->performances as $perf) {
            $result += $perf->amount;
        }
        return $result;
    }

    private function totalVolumeCredits(): float
    {
        $result = 0;
        foreach ($this->performances as $perf) {
            $result += $perf->volumeCredits;
        }
        return $result;
    }

    private function enrichPerformance($performance)
    {
        $result                = $performance;
        $result->play          = $this->playFor($performance);
        $result->amount        = $this->amountFor($performance);
        $result->volumeCredits = $this->volumeCreditsFor($performance);
        return $result;
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