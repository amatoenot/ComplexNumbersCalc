<?php

declare(strict_types=1);

namespace App\Entity;

class ComplexNumber
{
    /**
     * @var float
     */
    private $realValue;
    /**
     * @var float
     */
    private $imaginaryValue;

    public function __construct(float $realValue = 0, float $imaginaryValue = 0)
    {
        $this->realValue = $realValue;
        $this->imaginaryValue = $imaginaryValue;
    }

    /**
     * @return float
     */
    public function getRealValue(): float
    {
        return $this->realValue;
    }

    /**
     * @param float $realValue
     */
    public function setRealValue(float $realValue): void
    {
        $this->realValue = $realValue;
    }

    /**
     * @return float
     */
    public function getImaginaryValue(): float
    {
        return $this->imaginaryValue;
    }

    /**
     * @param float $imaginaryValue
     */
    public function setImaginaryValue(float $imaginaryValue): void
    {
        $this->imaginaryValue = $imaginaryValue;
    }
}