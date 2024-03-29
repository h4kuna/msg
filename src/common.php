<?php declare(strict_types=1);

use h4kuna\Dir;
use h4kuna\Queue;

if (!extension_loaded('sysvmsg')) {
	throw new RuntimeException('Let\'s install sysvmsg extension.');
}

require __DIR__ . '/../vendor/autoload.php';
define('TEMP_DIR', __DIR__ . '/../temp');
define('LOG_DIR', __DIR__ . '/../log');
(new Dir\Dir(LOG_DIR))->create();

$emailFile = __DIR__ . '/email';
$email = is_file($emailFile) ? trim(file_get_contents($emailFile)) : null;
Tracy\Debugger::enable(false, LOG_DIR, $email);

function createQueue(): Queue\Queue
{
	$tempDir = new Dir\Dir(TEMP_DIR);
	return (new Queue\QueueFactory(permission: 0o600, tempDir: $tempDir, messageSize: 64))
		->create('test');
}


function logger(string $name, string $message): void
{
	file_put_contents((new Dir\Dir(LOG_DIR))->filename($name, 'log'),
		sprintf('[%s] pid[%s] %s%s', date(DateTime::ATOM), getmypid(), $message, PHP_EOL), FILE_APPEND);
}
