<?php

/*
	Here are the questions, please take a look at all the other options at
	the bottom of this file. You can set virtually anything there. Please
	make sure your numbering starts at 1, and note that wb_exam will
	currently ask the questions 1 to <number of questions>. If a question
	number is missing people will only see a Submit button...
	* "scores" is _always_ an array: answer => score
	* Check your comma's carefully
	* OPEN type questions can have multiple answers with different scoring ;-)
*/

$questions = array(
	
	1 => array(
			"question" => "What's the email-address of this plugin's author?",
			"type" => "OPEN",
			"scores" => array (
				"wander@tomaatnet.nl" => 1,
				"wander@kanslozebagger.org" => 2
			)
		),
	
	2 => array(
			"question" => "What's the correct location to install a WordPress plugin:",
			"type" => "RADIO",
			"options" => array(
				1 => "/wp-content/plugins",
				2 => "/wp-content/extras",
				3 => "/wp-extras/content",
				4 => "/wp-extras/plugins"
			),
			"scores" => array (
				1 => 1,
				2 => -4,
				3 => -6,
				4 => -5
			)
		),
	
	3 => array(
			"question" => "Which of the following is true?<br />Check all that apply.",
			"type" => "CHECK",
			"options" => array(
				1 => "This is the last question of this test.",
				2 => "I'll buy Wander a beer next time I meet him.",
				3 => "This plugin rocks!"
			),
			"scores" => array (
				1 => 1, 
				2 => 3, 
				3 => 1
			)
		) /* Please not the ABSENCE of a comma after the last question */
);
	
/*
	Rankings have three fields:
	"lower" is the lowest score for which you'll get this text
	"upper" is the highest score for which you'll get this answer
	"text" is the text you'll get. "text" must contain exactly _one_ instance
	%s, which will replaced by your score.
*/


$rankings = array (
	1 => array(
		"lower" => -999,
		"upper" => 0,
		"text" => "<h3>Not to good</h3>You only managed to score %s points<br />Please come back later and try again"
	),
	2 => array(
		"lower" => 1,
		"upper" => 4,
		"text" => "<h3>Average</h3>You managed to score %s points<br />Please come back later and try again"
	),
	3 => array(
		"lower" => 5,
		"upper" => 7,
		"text" => "<h3>Almost there!</h3>You managed to score %s points<br />This is the sign of a true fan!"
	),
	4 => array(
		"lower" => 8,
		"upper" => 10,
		"text" => "<h3>Excellent!</h3>You managed to score %s points<br />Either you're cheating or you're cool!"
	)
);

/*
	The text on the submit button
*/

$submit_button_string = "Score my answers!";

/*
	The String at the top of the questions
*/

$intro_string = "<h3>Welcome</h3>Welcome to the default wbQuiz questions. These questions are meant to show the capabilities of this plugin.<br />To use this plugin put a wb_quiz(); tag in a page_template and add a custom key 'question_file' to your page pointing to your questions and quiz-settings.<br />Please press the button below to continue to the first question.";

/*
	The strings for asking a questions. This string _must_ contain two %s
	The first will replaced by the question number, the second one will be
	replaced by the actual question.
*/

$question_string = "<h3>Question %s:</h3><br />%s<br />";

?>
