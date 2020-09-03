<?php declare(strict_types=1);

require __DIR__ . '/src/common.php';

do {
	try {
		$message = receive();
		break;
	} catch (ReceiveException $e) {
		logger('msg_receive', $e->getMessage());
	}
} while (1);

logger('received', sprintf('Message: %s, Type: %s', $message['message'], $message['type']));
