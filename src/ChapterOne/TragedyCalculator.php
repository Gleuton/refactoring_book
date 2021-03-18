<?php


namespace Refactoring\ChapterOne;


class TragedyCalculator extends PerformanceCalculator
{
    public function amount(): float
    {
        $result = 40000;
        if ($this->performance->audience > 30) {
            $result += 1000 * ($this->performance->audience - 30);
        }
        return $result / 100;
    }

    public function volumeCredits(): int
    {
        return max($this->performance->audience - 30, 0);
    }
}