<?php


namespace Refactoring\ChapterOne;


class Statement
{
    public function statement($invoice, $plays): string
    {
        $totalAmount   = 0;
        $volumeCredits = 0;

        $result = "Statement for {$invoice->customer}\n";

        $format = static function (float $value) {
            return '$' . number_format($value, 2);
        };

        foreach ($invoice->performances as $perf) {
            $play       = $plays->{$perf->playID};
            $thisAmount = $this->amountFor($perf, $play);

            // add volume credits
            $volumeCredits += max($perf->audience - 30, 0);
            // add extra credit for every ten comedy attendees
            if('comedy'=== $play->type) $volumeCredits += floor($perf->audience / 5);
            // print line for this order
            $result .= "{$play->name}: {$format($thisAmount/100)} 
        ({$perf->audience} seats)\n";
            $totalAmount += $thisAmount;
        }

        $result .= "Amount owed is {$format($totalAmount/100)}\n";
        $result .= "You earner {$volumeCredits} credits\n";

        return $result;
    }

    public function amountFor($perf, $play)
    {
        switch ($play->type) {
            case 'tragedy':
                $amount = 40000;
                if ($perf->audience > 30) {
                    $amount += 1000 * ($perf->audience - 30);
                }
                break;
            case 'comedy':
                $amount = 30000;
                if ($perf->audience > 20) {
                    $amount += 10000 + 500 * ($perf->audience - 20);
                }
                $amount += 300 * $perf->audience;
                break;
            default:
                throw new \Error("unknown type: {$play->type}");
        }
        return $amount;
    }
}