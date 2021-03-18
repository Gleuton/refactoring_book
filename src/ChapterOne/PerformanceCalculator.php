<?php


namespace Refactoring\ChapterOne;


class PerformanceCalculator
{
    public object $performance;
    public object $play;

    public function __construct(object $performance, object $play)
    {
        $this->performance = $performance;
        $this->play        = $play;
    }

    public function amount(): float
    {
        switch ($this->play->type) {
            case 'tragedy':
                $result = 40000;
                if ($this->performance->audience > 30) {
                    $result += 1000 * ($this->performance->audience - 30);
                }
                break;
            case 'comedy':
                $result = 30000;
                if ($this->performance->audience > 20) {
                    $result += 10000 + 500 * (
                        $this->performance->audience - 20
                        );
                }
                $result += 300 * $this->performance->audience;
                break;
            default:
                throw new \Error("unknown type: {$this->play->type}");
        }
        return $result / 100;
    }

    public function volumeCredits(): int
    {
        $result = max($this->performance->audience - 30, 0);
        if ('comedy' === $this->play->type) {
            $result += floor($this->performance->audience / 5);
        }
        return $result;
    }
}