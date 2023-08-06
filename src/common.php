<?php declare(strict_types=1);

if (!extension_loaded('sysvmsg')) {
	throw new \RuntimeException('Let\'s install sysvmsg extension.');
}

interface MsgConfig
{
	const NO_SERIALIZE = false;
	const MESSAGE_TYPE = 1;
	const MESSAGE_SIZE_BYTES = 128;
	const SEND_BLOCKING = true;
}

/**
 * @return resource
 */
function queue()
{
	$key = ftok(__FILE__, 'a');
	return msg_get_queue($key, 0666);
}

final class SendException extends \RuntimeException
{

}

function send(string $message): void
{
	$error = 0;
	$success = @msg_send(queue(), MsgConfig::MESSAGE_TYPE, $message, MsgConfig::NO_SERIALIZE, MsgConfig::SEND_BLOCKING,
		$error);
	if (!$success || $error !== 0) {
		throw new SendException(sprintf('msg_send failed with error code "%s".', $error), $error);
	}
}

final class ReceiveException extends \RuntimeException
{

}

/**
 * @return array{message: string, type: int}
 */
function receive(): array
{
	$message = '';
	$msgType = $error = 0;
	$success = msg_receive(
		queue(),
		MsgConfig::MESSAGE_TYPE,
		$msgType,
		MsgConfig::MESSAGE_SIZE_BYTES,
		$message,
		MsgConfig::NO_SERIALIZE,
		0,
		$error
	);

	if (!$success || $error !== 0) {
		throw new ReceiveException(sprintf('msg_receive failed with error code "%s".', $error), $error);
	}

	return [
		'message' => $message,
		'type' => $msgType,
	];
}


function remove(): void
{
	msg_remove_queue(queue());
}


function logger(string $name, string $message): void
{
	file_put_contents(__DIR__ . "/../$name.log",
		sprintf('[%s] pid[%s] %s%s', date(\DateTime::ISO8601), getmypid(), $message, PHP_EOL), FILE_APPEND);
}
