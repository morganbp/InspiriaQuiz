<?php
namespace QuizApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class QuizMessageInterface implements MessageComponentInterface{
	// store clients in a SplObjectStorage
	protected $clients;
	protected $quizHandler;
	
	public function __construct(){
		$this->clients = new \SplObjectStorage;
		$this->quizHandler = new QuizHandler();
	}
	
	public function onOpen(ConnectionInterface $conn){
		// store the new connection to send messages to later
		$this->clients->attach($conn);
		
		echo "New connection! ({$conn->resourceId})\n";
	}
	
	public function onMessage(ConnectionInterface $from, $msg){
		
		$jsonData = json_decode($msg, true);
		
		$requestType = $jsonData["request-type"];
		
		echo "messsage " . $msg. "\n";
		
		$result = "";
		echo $requestType;
		switch($requestType){
			case QuizHandler::$CREATE_QUIZ_SESSION:
				/*
				*	Runs when a host wants to run a new QUIZ SESSION
				*/
				echo "Create
				$result = $this->quizHandler->createQuizSession($jsonData["quiz-id"], $from);
				
				break;

			case QuizHandler::$CONNECT_TO_QUIZ:
				/*
				*	Runs when a client want to connect to a quiz
				*/
				$result = $this->quizHandler->getQuizSession($jsonData["quiz-key"], $jsonData["username"] ,$from);
				break;
			
			case QuizHandler::$NEXT_QUESTION:
				/*
				*	Runs when a host wants to run a new QUIZ SESSION
				*/
				$result = $this->quizHandler->nextQuestion($jsonData["quiz-key"]);
				break;
			
			case QuizHandler::$ANSWERE_QUESTION:
				/*
				*	Runs when a host wants to run a new QUIZ SESSION
				*/
				break;
			
			case QuizHandler::$DELETE_QUIZ_SESSION:
				/*
				*	Runs when a host wants to run a new QUIZ SESSION
				*/
				break;
			
		}
		
		if($result != ""){
			$from->send($result);
		}
		

	}
	
	public function onClose(ConnectionInterface $conn){
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach($conn);
		$this->quizHandler->removeConnection($conn);
		echo "Connection {$conn->resourceId} has disconnected\n";
	}
	
	public function onError(ConnectionInterface $conn, \Exception $e){
		echo "An error has occured: {$e->getMessage()}\n";
		$conn->close();
	}
}