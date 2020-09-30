<?php

declare(strict_types=1);

namespace common\Complex;

class ComplexNumber
{
    /** @var float */
    private $real;

    /** @var float */
    private $imaginary;

    /**
     * @param float $real
     * @param float $imaginary
     */
    public function __construct(float $real, float $imaginary)
    {
        if ($real === 0 && $imaginary === 0) {
            throw new \Exception('RE and IM === 0');
        }

        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    /**
     * @param ComplexNumber $complexNumber
     *
     * @return self
     */
    public function add(ComplexNumber $complexNumber): self
    {
        $this->real += $complexNumber->getReal();
        $this->imaginary += $complexNumber->getImaginary();

        return $this;
    }

    /**
     * @param ComplexNumber $complexNumber
     *
     * @return self
     */
    public function subtract(ComplexNumber $complexNumber): self
    {
        $this->real -= $complexNumber->getReal();
        $this->imaginary -= $complexNumber->getImaginary();

        return $this;
    }

    /**
     * @param ComplexNumber $complexNumber
     *
     * @return self
     */
    public function multiply(ComplexNumber $complexNumber): self
    {
        $this->real = ($this->getReal() * $complexNumber->getReal())
            - ($this->getImaginary() * $complexNumber->getImaginary())
        ;

        $this->imaginary = ($this->getReal() * $complexNumber->getImaginary())
            + ($this->getImaginary() * $complexNumber->getReal())
        ;

        return $this;
    }

    /**
     * @param ComplexNumber $complexNumber
     *
     * @return self
     */
    public function divide(ComplexNumber $complexNumber): self
    {
        $this->real = ($this->getReal() * $complexNumber->getReal()) + ($this->getImaginary() * $complexNumber->getImaginary())
            / ($complexNumber->getReal() ** 2 + $complexNumber->getImaginary() ** 2)
        ;

        $this->imaginary = ($this->getImaginary() * $complexNumber->getReal()) - ($this->getReal() * $complexNumber->getImaginary())
            / ($complexNumber->getReal() ** 2 + $complexNumber->getImaginary() ** 2)
        ;

        return $this;
    }

    /**
     * @return float
     */
    public function getReal(): float
    {
        return $this->real;
    }

    /**
     * @return float
     */
    public function getImaginary(): float
    {
        return $this->imaginary;
    }
}