<?php
namespace QuizApp;

class QuizHandler {

	public static $CREATE_QUIZ_SESSION = "CREATE_QUIZ_SESSION_SESSION";
	public static $CONNECT_TO_QUIZ = "CONNECT_TO_QUIZ";
	public static $NEXT_QUESTION = "NEXT_QUESTION";
	public static $ANSWERE_QUESTION = "ANSWERE_QUESTION";
	public static $DELETE_QUIZ_SESSION = "DELETE_QUIZ_SESSION";
	public static $INIT_QUIZ = "INIT_QUIZ";
	public static $NEW_PARTICIPANT = "NEW_PARTICIPANT";
	public static $UPDATED_PARTICIPANTS = "UPDATED_PARTICIPANTS";
	public static $ERROR_MESSAGE = "ERROR_MESSAGE";
	
	protected $quizzes;
	
	public function __construct(){
		$this->quizzes = new \SplObjectStorage;
	}
	
	public function createQuizSession($id, $host){
		$key = $this->generateQuizKey();
		$newQuiz = new Quiz($id, $host, $key);
		$this->quizzes->attach($newQuiz);
		$response = "";
		if($newQuiz->getQuiz() == NULL){
			$response = $this->genErr("Couldn't find quiz with ID: {$newQuiz->getId()}");
		}else{
			$response = '{"request-type":"'.QuizHandler::$INIT_QUIZ.'","data":'.$newQuiz->getQuiz().'}';
		}
		return $response;
	}
	
	public function getQuizSession($quizKey, $username, $conn){
		$quiz = $this->getQuizByKey($quizKey);

		if($quiz == NULL) return $this->genErr("Quiz session not found");
		
		if($quiz->addParticipant($username, $conn)){
			return json_encode(array("request-type"=>QuizHandler::$INIT_QUIZ,"data"=> $quiz->getQuiz()));
		}else{
			return $this->genErr("Username already exists");	
		}
	}
	
	public function destroyQuizSession($key){
		$quiz = $this->getQuizByKey($key);
		if($quiz == NULL) return false;
		
		$this->quizzes->detach($quiz);
		return true;
	}
	
	/**
		Removes all activities to a connection. If it's a participant in a quiz,
		the participant will be removed from that quiz. If it's a host of a quiz,
		the quiz will be removed.
	
		$conn	The connection object of the connection which shall be removed
	
	*/
	public function removeConnection($conn){
		
		// Loop through all active quizzes.
		
		foreach($this->quizzes as $quiz){
			
			if($quiz->isHosting($conn)){
				$this->destroyQuizSession($quiz->getQuizKey());
				continue;
			}
			
			// Checking if the participant is participating in this  quiz.
			// If he is, we will remove him from the quiz.
			// In case the participant are participating in several quizzes,
			// we will continue the loop.
			
			if($quiz->isParticipatingByConnection($conn)){
				$part = $quiz->getParticipantByConnection($conn);
				$quiz->removeParticipant($part->getUsername());
				continue;
			}
		}
	}
	
	public function getQuiz($id){
		foreach($this->quizzes as $quiz){
			if($quiz->getId() == $id){
					return $quiz;
			}
		}
		return NULL;
	}
	
	public function getQuizByKey($key){
		foreach($this->quizzes as $quiz){
			if($quiz->getQuizKey() == $key){
				return $quiz;
			}
		}
		return NULL;
	}
	
	public function genErr($message){
		
		return json_encode(array("request-type"=>QuizHandler::$ERROR_MESSAGE, "data"=>$message));
	}
	
	public function generateQuizKey(){
		$key;
		do{
			$key = Util::generateString();
			
		}while($this->isKeyUsed($key));
		return $key;
	}
	
	public function isKeyUsed($key){
		if($this->getQuizByKey($key) == NULL){
			return false;	
		}else{
			return true;
		}
	}
	
	public function nextQuestion($key){
		$quiz = $this->getQuizByKey($key);
		$quiz->nextQuestion();
		
	}
}