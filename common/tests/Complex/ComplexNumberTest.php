<?php

declare(strict_types=1);

namespace common\tests\Complex;

use common\Complex\ComplexNumber;
use Exception;

class ComplexNumberTest extends TestCase
{
    /** @var ComplexNumber */
    private $complexNumber1;

    /** @var ComplexNumber */
    private $complexNumber2;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->complexNumber1 = new ComplexNumber(2, 5);
        $this->complexNumber2 = new ComplexNumber(-3, -4);
    }

    /**
     * @throws Exception
     */
    public function testException(): void
    {
        $this->expectException(Exception::class);

        $complexNumber = new ComplexNumber(0, 0);
    }

    /**
     * @throws Exception
     */
    public function testAdd(): void
    {
        $this->complexNumber1->add($this->complexNumber2);

        $expectComplexNumber = new ComplexNumber(-1, 1);

        $this->assertEquals(
            [
                $expectComplexNumber->getReal(),
                $expectComplexNumber->getImaginary(),
            ],
            [
                $this->complexNumber1->getReal(),
                $this->complexNumber1->getImaginary(),
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function testSubtract(): void
    {
        $this->complexNumber1->subtract($this->complexNumber2);

        $expectComplexNumber = new ComplexNumber(5, 9);

        $this->assertEquals(
            [
                $expectComplexNumber->getReal(),
                $expectComplexNumber->getImaginary(),
            ],
            [
                $this->complexNumber1->getReal(),
                $this->complexNumber1->getImaginary(),
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function testMultiply(): void
    {
        $this->complexNumber1->multiply($this->complexNumber2);

        $expectComplexNumber = new ComplexNumber(14, -23);

        $this->assertEquals(
            [
                $expectComplexNumber->getReal(),
                $expectComplexNumber->getImaginary(),
            ],
            [
                $this->complexNumber1->getReal(),
                $this->complexNumber1->getImaginary(),
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function testDivide(): void
    {
        $this->complexNumber1->divide($this->complexNumber2);

        $expectComplexNumber = new ComplexNumber((-26 / 25), (-7 / 25));

        $this->assertEquals(
            [
                $expectComplexNumber->getReal(),
                $expectComplexNumber->getImaginary(),
            ],
            [
                $this->complexNumber1->getReal(),
                $this->complexNumber1->getImaginary(),
            ]
        );
    }
}