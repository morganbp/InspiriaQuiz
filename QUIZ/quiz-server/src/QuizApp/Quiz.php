<?php
namespace QuizApp;

class Quiz {

	private $quizKey;
	private $id;
	private $host;
	private $participants;
	private $currentQuestion;
	
	public function __construct($id, $host, $quizKey){
		$this->host = $host;
		$this->participants = new \SplObjectStorage;
		$this->quizKey = $quizKey;
		$this->currentQuestion = -1;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getHost(){
		return $this->host;
	}
	
	public function getQuizKey(){
		return $this->quizKey;	
	}
	
	public function getCurrentQuestion(){
		return $this->currentQuestion;	
	}
	
	public function addParticipant($username, $conn){
		$participant = new Participant($username, $conn);
		// Check if there is NOT a participant with same username
		if(!$this->isParticipating($username)){
			$this->participants->attach($participant);
			$this->broadcastParticipants(QuizHandler::$UPDATED_PARTICIPANTS);
			return true;
		}else{
			return false;	
		}
	}
	
	public function removeParticipant($participantUsername){
		$participant = $this->getParticipantByUsername($participantUsername);
		if($participant == NULL) return false;
		$this->participants->detach($participant);
		$this->broadcastParticipants(QuizHandler::$UPDATED_PARTICIPANTS);
		return true;
	}
	
	public function getParticipantByUsername($username){
		foreach($this->participants as $part){
			if($part->getUsername() == $username){
				return $part;	
			}
		}
		return NULL;
	}
	
	public function getParticipantByConnection($conn){
		foreach($this->participants as $part){
			if($part->getConnection() == $conn){
				return $part;	
			}
		}
		return NULL;
	}
	
	public function isHosting($conn){
		if($conn == $this->getHost()){
			return true;	
		}else{
			return false;	
		}
	}
	
	public function isParticipating($username){
		$part = $this->getParticipantByUsername($username);
		if($part == NULL){
			return false;	
		}else{
			return true;	
		}
	}
	
	public function isParticipatingByConnection($conn){
		$part = $this->getParticipantByConnection($conn);
		if($part == NULL){
			return false;
		}else{
			return true;	
		}
	}
	
	public function getQuiz(){
		return '{"quiz-key":"'. $this->quizKey . '", "quiz":[{"question":"How old are you?", "alternatives":[{"alternative":"10"},{"alternative":"20"},{"alternative":"30"},{"alternative":"40"}]},{"question":"What is your favorite color?", "alternatives":[{"alternative":"green"},{"alternative":"yellow"},{"alternative":"blue"},{"alternative":"red"}]}]}';	
	}
	
	public function nextQuestion(){		
		$this->currentQuestion++;
		
		$this->broadcastAll(array("current-question"=>$this->getCurrentQuestion()),QuizHandler::$NEXT_QUESTION , false);
		
	}
	
	public function broadcastParticipants($requestType){
		$data = array();
		$data["participants"] = array();
		foreach ($this->participants as $part){
				array_push($data["participants"],(array("username"=>$part->getUsername(), "score"=> $part->getScore())));
		}
		
	
		$this->broadcastAll($data,  $requestType);
	}
	
	/**
	*
	*	This function sends a chunk of data to all participants and optionally
	*	the host.
	*
	*	$data 	Array of data which will be broadcasted
	*	$includeHost 	True if data will be send to the host, false if data only 
	*					will be sendt to participants
	*
	*/
	public function broadcastAll($data, $requestType, $includeHost = true){
		$jsonData = json_encode(array("request-type"=>$requestType, "data"=>$data));

		if($includeHost){
			$this->host->send($jsonData);	
		}
		
		foreach($this->participants as $part){
			$part->getConnection()->send($jsonData);	
		}
	}
	
}