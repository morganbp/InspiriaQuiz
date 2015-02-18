<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use QuizApp\QuizMessageInterface;

	require dirname(__DIR__).'\vendor\autoload.php';

	$server = IoServer::factory(
		new HttpServer(
			new WsServer(
				new QuizMessageInterface()
			)
		),
		8080
	);

	$server->run();