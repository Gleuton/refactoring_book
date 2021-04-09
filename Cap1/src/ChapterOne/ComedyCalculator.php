<?php


namespace Refactoring\ChapterOne;


class ComedyCalculator extends PerformanceCalculator
{
    public function amount(): float
    {
        $result = 30000;
        if ($this->performance->audience > 20) {
            $result += 10000 + 500 * (
                    $this->performance->audience - 20
                );
        }
        $result += 300 * $this->performance->audience;

        return $result / 100;
    }

    public function volumeCredits(): int
    {
        $result = max($this->performance->audience - 30, 0);
        return $result + floor($this->performance->audience / 5);
    }
}