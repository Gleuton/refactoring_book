<?php


namespace Refactoring\ChapterOne;


abstract class PerformanceCalculator
{
    public object $performance;
    public object $play;

    public function __construct(object $performance, object $play)
    {
        $this->performance = $performance;
        $this->play        = $play;
    }

    abstract public function volumeCredits(): int;
    abstract public function amount(): float;
}