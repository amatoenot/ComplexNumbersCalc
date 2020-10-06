<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Entity\ComplexNumber;
use App\Service\ComplexNumberCalculator;

$complexNumberCalculator = new ComplexNumberCalculator();
$a = new ComplexNumber(0.12, 5.5);
$b = new ComplexNumber(12.3, -7.19);
$result = $complexNumberCalculator->division($a, $b);

echo sprintf('Результат деления: %s + %si', $result->getRealValue(), $result->getImaginaryValue()).PHP_EOL;