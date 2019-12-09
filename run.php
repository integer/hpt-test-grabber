<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
	echo 'This script must be run from CLI.';
	exit(1);
}

if ($_SERVER['argc'] !== 2) {
	printf('Use with input file name: php %s input-file.txt', $argv[0]);
	exit(2);
}

require __DIR__ . '/vendor/autoload.php';

$loader = new \Nette\DI\ContainerLoader(__DIR__ . '/temp');
$class = $loader->load(function(\Nette\DI\Compiler $compiler) {
	$compiler->loadConfig(__DIR__ . '/config.neon');
});
/** @var \Nette\DI\Container $container */
$container = new $class;

$dispatcher = $container->getByType(\HPT\Dispatcher::class);
echo $dispatcher->run($argv[1]);
