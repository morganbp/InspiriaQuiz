<?php
namespace QuizApp;

class Util {
	
	public static function generateString($length = 5){
		$generatedString = "";
		for($i = 0; $i < $length; $i++){
			$number = floor(rand(0,9));
			$generatedString .= $number;
		}
		return $generatedString;
	}
	
}