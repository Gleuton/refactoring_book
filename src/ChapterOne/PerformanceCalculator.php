<?php


namespace Refactoring\ChapterOne;


class PerformanceCalculator
{
    public object $performance;
    public object $play;

    public function __construct(object $performance, object $play)
    {
        $this->performance = $performance;
        $this->play = $play;
    }
}