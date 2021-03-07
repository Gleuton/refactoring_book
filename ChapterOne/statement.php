<?php

function statement($invoice, $plays): string
{
    $totalAmount   = 0;
    $volumeCredits = 0;

    $result = "Statement for {$invoice->customer}<br>";

    $format = static function (float $value) {
        return '$' . number_format($value, 2);
    };

    foreach ($invoice->performances as $perf) {
        $play       = $plays->{$perf->playID};
        $thisAmount = 0;
        switch ($play->type) {
            case 'tragedy':
                $thisAmount = 40000;
                if ($perf->audience > 30) {
                    $thisAmount += 1000 * ($perf->audience - 30);
                }
                break;
            case 'comedy':
                $thisAmount = 30000;
                if ($perf->audience > 20) {
                    $thisAmount += 10000 + 500 * ($perf->audience - 20);
                }
                $thisAmount += 300 * $perf->audience;
                break;
            default:
                throw new Error("unknown type: {$play->type}");
        }
        // add volume credits
        $volumeCredits += max($perf->audience - 30, 0);
        // add extra credit for every ten comedy attendees
        if('comedy'=== $play->type) $volumeCredits += floor($perf->audience / 5);
        // print line for this order
        $result .= "{$play->name}: {$format($thisAmount/100)} 
        ({$perf->audience} seats)<br>";
        $totalAmount += $thisAmount;
    }

    $result .= "Amount owed is {$format($totalAmount/100)}<br>";
    $result .= "You earner {$volumeCredits} credits<br>";

    return $result;
}