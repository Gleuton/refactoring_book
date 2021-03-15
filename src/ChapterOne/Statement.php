<?php


namespace Refactoring\ChapterOne;


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

        $format = static function (float $value) {
            return '$' . number_format($value, 2);
        };

        foreach ($this->invoice->performances as $perf) {
            $thisAmount = $this->amountFor($perf, $this->playFor($perf));

            // add volume credits
            $volumeCredits += max($perf->audience - 30, 0);
            // add extra credit for every ten comedy attendees
            if ('comedy' === $this->playFor($perf)->type) {
                $volumeCredits += floor($perf->audience / 5);
            }
            // print line for this order
            $result      .= "{$this->playFor($perf)->name}: {$format($thisAmount/100)} 
        ({$perf->audience} seats)\n";
            $totalAmount += $thisAmount;
        }

        $result .= "Amount owed is {$format($totalAmount/100)}\n";
        $result .= "You earner {$volumeCredits} credits\n";

        return $result;
    }

    private function playFor($perf)
    {
        return $this->plays->{$perf->playID};
    }

    public function amountFor($perf, $play)
    {
        switch ($play->type) {
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
                throw new \Error("unknown type: {$play->type}");
        }
        return $result;
    }
}