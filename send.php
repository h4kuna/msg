<?php declare(strict_types=1);

require __DIR__ . '/src/common.php';

createQueue()->producer()->send((string) random_int(5, 20));

echo 'Message sent' . PHP_EOL;
