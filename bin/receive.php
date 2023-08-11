<?php declare(strict_types=1);

use h4kuna\Queue\Exceptions;

require __DIR__ . '/../src/common.php';
$queue = createQueue();
$queue->restore();

try {
	$message = $queue->consumer()->receive();
	logger('received', sprintf('Message: %s, Type: %s', $message->message, $message->type));
	echo $message->message . PHP_EOL;
	sleep((int) $message->message);
} catch (Exceptions\ReceiveException $e) {
	sleep(1);
	throw $e;
}

