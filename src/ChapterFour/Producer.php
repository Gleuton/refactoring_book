<?php


namespace Refactoring\ChapterFour;


class Producer
{
    private Province $province;
    private float $cost;
    private string $name;
    private int $production;

    public function __construct(
        Province $province,
        $data
    ) {
        $this->province = $province;
        $this->cost = $data->cost;
        $this->name = $data->name;
        $this->production = $data->production ?? 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function setCost(float $cost): void
    {
        $this->cost = $cost;
    }

    public function getProduction(): int
    {
        return $this->production;
    }

    public function setProduction(int $amount): void
    {
        $newProduction = $amount - $this->production;
        $this->province->addTotalProduction($newProduction);
        $this->production = $amount;
    }

}