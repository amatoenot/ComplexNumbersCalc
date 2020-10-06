<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Entity\ComplexNumber;
use App\Exception\ComplexNumberCalculatorException;
use App\Service\ComplexNumberCalculator;
use PHPUnit\Framework\TestCase;

class ComplexNumberCalculatorTest extends TestCase
{
    /**
     * @param ComplexNumber $a
     * @param ComplexNumber $b
     * @param bool $isEqual
     * @dataProvider equalityProvider
     */
    public function testEquals(ComplexNumber $a, ComplexNumber $b, bool $isEqual)
    {
        $complexNumberCalculator = new ComplexNumberCalculator();
        $this->assertSame($isEqual, $complexNumberCalculator->equals($a, $b));
    }

    public function equalityProvider()
    {
        return [
            [new ComplexNumber(), new ComplexNumber(), true],
            [new ComplexNumber(0, 1), new ComplexNumber(1, 0), false],
            [new ComplexNumber(0.12, 5.5), new ComplexNumber(-0.12, 5.5), false],
            [new ComplexNumber(5.23, -18.2), new ComplexNumber(5.23, -18.2), true]
        ];
    }

    /**
     * @param ComplexNumber $leftOperand
     * @param ComplexNumber $rightOperand
     * @param ComplexNumber $expectedResult
     * @dataProvider additionProvider
     * @depends testEquals
     */
    public function testAddition(ComplexNumber $leftOperand, ComplexNumber $rightOperand, ComplexNumber $expectedResult)
    {
        $complexNumberCalculator = new ComplexNumberCalculator();
        $result = $complexNumberCalculator->addition($leftOperand, $rightOperand);
        $this->assertTrue($complexNumberCalculator->equals($expectedResult, $result));
    }

    public function additionProvider()
    {
        return [
            [new ComplexNumber(), new ComplexNumber(), new ComplexNumber()],
            [new ComplexNumber(0, 1), new ComplexNumber(1, 0), new ComplexNumber(1, 1)],
            [new ComplexNumber(0.12, 5.5), new ComplexNumber(-0.12, 5.5), new ComplexNumber(0, 11)],
            [new ComplexNumber(5.23, -18.2), new ComplexNumber(5.23, -18.2), new ComplexNumber(10.46, -36.4)]
        ];
    }

    /**
     * @param ComplexNumber $leftOperand
     * @param ComplexNumber $rightOperand
     * @param ComplexNumber $expectedResult
     * @depends testEquals
     * @dataProvider subtractionProvider
     */
    public function testSubtraction(ComplexNumber $leftOperand, ComplexNumber $rightOperand, ComplexNumber $expectedResult)
    {
        $complexNumberCalculator = new ComplexNumberCalculator();
        $result = $complexNumberCalculator->subtraction($leftOperand, $rightOperand);
        $this->assertTrue($complexNumberCalculator->equals($expectedResult, $result));
    }

    public function subtractionProvider()
    {
        return [
            [new ComplexNumber(), new ComplexNumber(), new ComplexNumber()],
            [new ComplexNumber(0, 1), new ComplexNumber(1, 0), new ComplexNumber(-1, 1)],
            [new ComplexNumber(0.12, 5.5), new ComplexNumber(-0.12, 5.5), new ComplexNumber(0.24, 0)],
            [new ComplexNumber(5.23, -18.2), new ComplexNumber(5.23, -18.2), new ComplexNumber()]
        ];
    }

    /**
     * @param ComplexNumber $leftOperand
     * @param ComplexNumber $rightOperand
     * @param ComplexNumber $expectedResult
     * @depends testEquals
     * @dataProvider multiplicationProvider
     */
    public function testMultiplication(ComplexNumber $leftOperand, ComplexNumber $rightOperand, ComplexNumber $expectedResult)
    {
        $complexNumberCalculator = new ComplexNumberCalculator();
        $result = $complexNumberCalculator->multiplication($leftOperand, $rightOperand);
        $this->assertTrue($complexNumberCalculator->equals($expectedResult, $result));
    }

    public function multiplicationProvider()
    {
        return [
            [new ComplexNumber(), new ComplexNumber(), new ComplexNumber()],
            [new ComplexNumber(0, 1), new ComplexNumber(1, 0), new ComplexNumber(0, 1)],
            [new ComplexNumber(0.12, 5.5), new ComplexNumber(-0.12, 5.5), new ComplexNumber(-30.2644)],
            [new ComplexNumber(5.23, -18.2), new ComplexNumber(5.23, -18.2), new ComplexNumber(-303.8871, -190.372)]
        ];
    }

    /**
     * @param ComplexNumber $leftOperand
     * @param ComplexNumber $rightOperand
     * @param ComplexNumber $expectedResult
     * @depends testEquals
     * @dataProvider divisionProvider
     */
    public function testDivision(ComplexNumber $leftOperand, ComplexNumber $rightOperand, ComplexNumber $expectedResult)
    {
        $complexNumberCalculator = new ComplexNumberCalculator();
        $result = $complexNumberCalculator->division($leftOperand, $rightOperand);
        $this->assertTrue($complexNumberCalculator->equals($expectedResult, $result));
    }

    public function divisionProvider()
    {
        return [
            [
                new ComplexNumber(),
                new ComplexNumber(1, 1),
                new ComplexNumber()
            ],
            [
                new ComplexNumber(0, 1),
                new ComplexNumber(1, 0),
                new ComplexNumber(0, 1)
            ],
            [
                new ComplexNumber(0.12, 5.5),
                new ComplexNumber(-0.12, 5.5),
                new ComplexNumber(
                    floatval(bcdiv('30.2356', '30.2644', 32)),
                    floatval(bcdiv('-1.32', '30.2644', 32))
                )
            ],
            [
                new ComplexNumber(5.23, -18.2),
                new ComplexNumber(5.23, -18.2),
                new ComplexNumber(1)
            ]
        ];
    }

    /**
     * @throws ComplexNumberCalculatorException
     */
    public function testZeroDivisionException()
    {
        $this->expectException(ComplexNumberCalculatorException::class);
        $complexNumberCalculator = new ComplexNumberCalculator();
        $complexNumberCalculator->division(
            new ComplexNumber(0.12, 5.5),
            new ComplexNumber()
        );
    }
}