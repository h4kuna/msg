<?php declare(strict_types=1);

use h4kuna\Queue\Exceptions;

require __DIR__ . '/../src/common.php';
$queue = createQueue();
start:
$queue->restore();
while (true) {
	try {
		$message = $queue->consumer()->receive();
		logger('received', sprintf('Message: %s, Type: %s', $message->message, $message->type));
		echo $message->message . PHP_EOL;
		sleep((int) $message->message);
	} catch (Exceptions\ReceiveException $e) {
		logger('msg_receive', $e->getMessage());
		error_get_last() && logger('msg_receive', error_get_last()['message']);
		error_clear_last();
		sleep(1);
		goto start;
	}
}
