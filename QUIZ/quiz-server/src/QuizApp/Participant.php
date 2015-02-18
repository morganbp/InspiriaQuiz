<?php
namespace QuizApp;

class Participant{
	
	private $conn;
	private $username;
	private $score;
	
	public function __construct($username,  $conn){
		$this->username = $username;
		$this->conn = $conn;
		$this->score = 0;
	}
	
	public function getConnection(){
		return $this->conn;	
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function getScore(){
		echo "SCORE: " . $this->score;
		return $this->score;
	}
	
	public function setScore($score){
		$this->score = $score;
	}
	
	public function addScore($points){
		$this->setScore($this->score + $points);
	}
	
	public function compareTo($participant){
		if($this->getUsername() == $participant->getUsername()){
			return true;	
		}else{
			return false;	
		}
	}
}