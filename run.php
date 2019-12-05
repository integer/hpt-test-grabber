<?php
declare(strict_types=1);

require_once 'IFetcher.php';
require_once 'IGrabber.php';
require_once 'IOutput.php';
require_once 'Dispatcher.php';
require_once 'DocumentFetcher.php';
require_once 'DocumentGrabber.php';
require_once 'ResultOutput.php';
require_once 'ProductNotFoundException.php';

$dispatcher = new Dispatcher(
	new DocumentFetcher(),
	new DocumentGrabber(),
	new ResultOutput()
);
echo $dispatcher->run();

