<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ComplexNumber;
use App\Exception\ComplexNumberCalculatorException;

class ComplexNumberCalculator
{
    public function __construct(int $scale = 32)
    {
        bcscale($scale);
    }

    /**
     * @param ComplexNumber $leftOperand
     * @param ComplexNumber $rightOperand
     * @return ComplexNumber
     */
    public function addition(ComplexNumber $leftOperand, ComplexNumber $rightOperand): ComplexNumber
    {
        return new ComplexNumber(
            floatval(
                bcadd(
                    (string)$leftOperand->getRealValue(),
                    (string)$rightOperand->getRealValue()
                )
            ),
            floatval(
                bcadd(
                    (string)$leftOperand->getImaginaryValue(),
                    (string)$rightOperand->getImaginaryValue()
                )
            )
        );
    }

    /**
     * @param ComplexNumber $leftOperand
     * @param ComplexNumber $rightOperand
     * @return ComplexNumber
     */
    public function subtraction(ComplexNumber $leftOperand, ComplexNumber $rightOperand): ComplexNumber
    {
        return new ComplexNumber(
            floatval(
                bcsub(
                    (string)$leftOperand->getRealValue(),
                    (string)$rightOperand->getRealValue()
                )
            ),
            floatval(
                bcsub(
                    (string)$leftOperand->getImaginaryValue(),
                    (string)$rightOperand->getImaginaryValue()
                )
            )
        );
    }

    /**
     * @param ComplexNumber $leftOperand
     * @param ComplexNumber $rightOperand
     * @return ComplexNumber
     */
    public function multiplication(ComplexNumber $leftOperand, ComplexNumber $rightOperand): ComplexNumber
    {
        return new ComplexNumber(
            floatval(
                bcsub(
                    bcmul((string)$leftOperand->getRealValue(), (string)$rightOperand->getRealValue()),
                    bcmul((string)$leftOperand->getImaginaryValue(), (string)$rightOperand->getImaginaryValue())
                )
            ),
            floatval(
                bcadd(
                    bcmul((string)$leftOperand->getRealValue(), (string)$rightOperand->getImaginaryValue()),
                    bcmul((string)$rightOperand->getRealValue(), (string)$leftOperand->getImaginaryValue())
                )
            )
        );
    }

    /**
     * @param ComplexNumber $dividend
     * @param ComplexNumber $divisor
     * @return ComplexNumber
     */
    public function division(ComplexNumber $dividend, ComplexNumber $divisor): ComplexNumber
    {
        if (floatval(0) === $divisor->getRealValue() && floatval(0) === $divisor->getImaginaryValue()) {
            throw new ComplexNumberCalculatorException("Division by zero is not allowed.");
        }
        return new ComplexNumber(
            floatval(
                bcdiv(
                    bcadd(
                        bcmul((string)$dividend->getRealValue(), (string)$divisor->getRealValue()),
                        bcmul((string)$dividend->getImaginaryValue(), (string)$divisor->getImaginaryValue())
                    ),
                    bcadd(
                        bcpow((string)$divisor->getRealValue(), '2'),
                        bcpow((string)$divisor->getImaginaryValue(), '2')
                    )
                )
            ),
            floatval(
                bcdiv(
                    bcsub(
                        bcmul((string)$dividend->getImaginaryValue(), (string)$divisor->getRealValue()),
                        bcmul((string)$dividend->getRealValue(), (string)$divisor->getImaginaryValue())
                    ),
                    bcadd(
                        bcpow((string)$divisor->getRealValue(), '2'),
                        bcpow((string)$divisor->getImaginaryValue(), '2')
                    )
                )
            )
        );
    }

    /**
     * @param ComplexNumber $a
     * @param ComplexNumber $b
     * @return bool
     */
    public function equals(ComplexNumber $a, ComplexNumber $b): bool
    {
        if (
            abs($a->getRealValue() - $b->getRealValue()) < PHP_FLOAT_EPSILON &&
            abs($a->getImaginaryValue() - $b->getImaginaryValue()) < PHP_FLOAT_EPSILON
        ) {
            return true;
        }
        return false;
    }
}