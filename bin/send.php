<?php declare(strict_types=1);

require __DIR__ . '/../src/common.php';

$producer = createQueue()->producer();

$delta = random_int(25, 50);

$start = $delta;
$end = $delta + 120;

for ($i = $start; $i < $end; ++$i) {
	$producer->send((string) $i);
}

echo 'Message sent' . PHP_EOL;
