<?php declare(strict_types=1);

use h4kuna\Dir;
use h4kuna\Queue;

if (!extension_loaded('sysvmsg')) {
	throw new RuntimeException('Let\'s install sysvmsg extension.');
}

require __DIR__ . '/../vendor/autoload.php';

function createQueue(): Queue\Queue
{
	$tempDir = (new Dir\Dir(__DIR__ . '/temp'))->create();
	return (new Queue\QueueFactory(tempDir: $tempDir))
		->create('test');
}


function logger(string $name, string $message): void
{
	file_put_contents(__DIR__ . "/../$name.log",
		sprintf('[%s] pid[%s] %s%s', date(DateTime::ATOM), getmypid(), $message, PHP_EOL), FILE_APPEND);
}
