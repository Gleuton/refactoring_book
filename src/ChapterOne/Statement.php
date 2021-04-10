<?php


namespace Refactoring\ChapterOne;


class Statement
{
    public string $customer;
    public array $performances;
    public float $totalAmount;
    public int $totalVolumeCredits;
    private object $plays;

    public function __construct(object $invoice, object $plays)
    {
        $this->plays              = $plays;
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
        $calculator = $this->createPerformanceCalculator(
            $performance,
            $this->playFor($performance)
        );

        $result                = clone $performance;
        $result->play          = $calculator->play;
        $result->amount        = $calculator->amount();
        $result->volumeCredits = $calculator->volumeCredits();
        return $result;
    }

    private function playFor($perf): object
    {
        return $this->plays->{$perf->playID};
    }

    private function createPerformanceCalculator(
        object $performance,
        object $play
    ): PerformanceCalculator {

        switch ($play->type) {
            case 'tragedy':
                return new TragedyCalculator($performance, $play);
            case 'comedy':
                return new ComedyCalculator($performance, $play);
            default:
                throw new \Error("unknown type: {$play->type}");
        }
    }
}