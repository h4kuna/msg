<?php declare(strict_types=1);

require __DIR__ . '/../src/common.php';
$queue = createQueue();
$info = $queue->information();

foreach ($info as $k => $v) {
	if ($v instanceof DateTimeInterface) {
		$v = $v->format(DateTime::ATOM);
	}
	echo "$k: $v\n";
}
