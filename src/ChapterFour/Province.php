<?php


namespace Refactoring\ChapterFour;


class Province
{
    private string $name;
    /**
     * @var Producer[]
     */
    private array $producers = [];
    private int $totalProduction = 0;
    private int $demand;
    private float $price;

    public function __construct($doc)
    {
        $this->name   = $doc->name;
        $this->demand = $doc->demand;
        $this->price  = $doc->price;
        foreach ($doc->producers as $producer) {
            $this->addProducer(new Producer($this, $producer));
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProducers(): array
    {
        return $this->producers;
    }

    public function getTotalProduction(): int
    {
        return $this->totalProduction;
    }

    public function getDemand(): int
    {
        return $this->demand;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function addTotalProduction(int $totalProduction): void
    {
        $this->totalProduction += $totalProduction;
    }

    public function setDemand(int $demand): void
    {
        $this->demand = $demand;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function shotFall(): int
    {
        return $this->demand - $this->totalProduction;
    }

    public function profit(): float
    {
        return $this->demandValue() - $this->demandCost();
    }

    public function demandValue(): float
    {
        return $this->satisFieldDemand() * $this->price;
    }

    public function satisFieldDemand(): float
    {
        return min($this->demand, $this->totalProduction);
    }

    public function demandCost(): float
    {
        $remainingDemand = $this->demand;
        $result          = 0;
        usort(
            $this->producers,
            static fn($a, $b) => ($a->getCost() - $b->getCost())
        );
        foreach ($this->producers as $p) {
            $contribution    = min($remainingDemand, $p->getProduction());
            $remainingDemand -= $contribution;
            $result          += $contribution * $p->getCost();
        }
        return $result;
    }

    private function addProducer(Producer $producer): void
    {
        $this->producers[]     = $producer;

        $this->totalProduction += $producer->getProduction();
    }
}