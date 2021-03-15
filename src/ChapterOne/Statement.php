<?php


namespace Refactoring\ChapterOne;


use Error;

class Statement
{
    private object $plays;
    private object $invoice;

    public function __construct(object $invoice, object $plays)
    {
        $this->plays   = $plays;
        $this->invoice = $invoice;
    }

    public function statement(): string
    {
        $totalAmount   = 0;
        $volumeCredits = 0;

        $result = "Statement for {$this->invoice->customer}\n";

        foreach ($this->invoice->performances as $perf) {

            // print line for this order
            $result .= "{$this->playFor($perf)->name}: {$this->usd(
                $this->amountFor($perf)
                )} 
        ({$perf->audience} seats)\n";
            $totalAmount += $this->amountFor($perf);
        }

        $volumeCredits = $this->totalVolumeCredits();

        $result .= "Amount owed is {$this->usd($totalAmount)}\n";

        return $result . "You earner {$volumeCredits} credits\n";
    }

    private function totalVolumeCredits(){
        $result = 0;
        foreach ($this->invoice->performances as $perf) {
            // add volume credits
            $result += $this->volumeCreditsFor($perf);
        }
        return $result;
    }

    private function usd(float $value): string
    {
        return '$' . number_format($value/100, 2);
    }
    private function playFor($perf)
    {
        return $this->plays->{$perf->playID};
    }

    private function volumeCreditsFor($perf){
        $result = max($perf->audience - 30, 0);
        // add extra credit for every ten comedy attendees
        if ('comedy' === $this->playFor($perf)->type) {
            $result += floor($perf->audience / 5);
        }
        return $result;
    }

    private function amountFor($perf)
    {
        switch ($this->playFor($perf)->type) {
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
                throw new Error("unknown type: {$this->playFor($perf)->type}");
        }
        return $result;
    }
}