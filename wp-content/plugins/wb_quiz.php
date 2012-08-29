<?php
/*
Plugin Name: wbQuiz
Plugin URI: http://kanslozebagger.org/wbquiz
Description: Add a quiz to your page
Version: 0.1.0
Author: Wander Boessenkool
Author URI: http://kanslozebagger.org
*/

/*  Copyright 2005 Wander Boessenkool  (email : wander@kanslozebagger.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/*
	The main function wb_quiz(). This is the one you'll use as a template tag
	in your pagetemplate. You can leave the_loop in your template to display
	the content of your page with _each_and_every_ question of your exam, or
	you can skip it entirely.
*/

function wb_quiz(){
	/*
		Some functions used by the <?php wb_quiz() ?> templatetag.
	*/
	
	function wb_quiz_score_question($nummer) {
		global $questions;
		$score = 0;
		if ($questions[$nummer]["type"] == "CHECK") {
			foreach ($questions[$nummer]["options"] as $key => $value) {
				if (isset($_POST["Q".$nummer."ANSW".$key])) {
					$score = $score + $questions[$nummer]["scores"][$key];
				}
			}
		}
		else {
			if (isset($questions[$nummer]["scores"][$_POST["Q".$nummer."ANSW"]])) {
				$score = $score + $questions[$nummer]["scores"][$_POST["Q".$nummer."ANSW"]];
			}
		}
		return $score;
	}

	function wb_quiz_evaluate() {
		global $questions, $rankings;
		$score = 0;
		foreach ($questions as $questno => $curquest) {
			$score = $score + wb_quiz_score_question($questno);
		}
		foreach ($rankings as $ranking) {
			if (($score >= $ranking["lower"]) and ($score <= $ranking["upper"])) {
				printf ($ranking["text"], $score);
			}
		}
	}

	function wb_quiz_ask_questions() {
		global $questions, $question_string, $submit_button_string, $intro_string;
		echo $intro_string;
		?> <br /><code><form method="post" action="<?php get_permalink(); ?>">
			<input type="hidden" name="evaluate" value="yep" /><?php
		foreach ($questions as $questno => $curquest) {
			printf($question_string, $questno, $curquest['question']);
			if ($curquest["type"] == "OPEN") { ?>
				<input type="text" name="Q<?php echo $questno; ?>ANSW"  size="40" maxlength="60" /> <br /> <?php
			}
			elseif ($curquest["type"] == "RADIO") {
				foreach ($curquest["options"] as $key => $antwoord) {  ?>
				<input type="radio" name="Q<?php echo $questno; ?>ANSW" value="<?php echo $key ?>" /><?php echo $antwoord ?> <br /><?php }
			}
			elseif ($curquest["type"] == "CHECK") {
				foreach ($curquest["options"] as $key => $antwoord) { ?>
					<input type="checkbox"
						name="Q<?php echo $questno; ?>ANSW<?php echo $key ?>"
						value="<?php echo $key ?>" /><?php echo $antwoord ?> <br /><?php
				}
			}
		}
		?><br /><input type="submit" name=".submit" value="<?php echo $submit_button_string ?>" />
		</form></code><?php
	}
	

/*
	First let's get and read our questions + settings
*/
	global $questions, $rankings, $question_string, $submit_button_string, $intro_string;
	$question_file = get_post_custom_values("question_file");
	if (!isset($question_file)) {
		$question_file[0] = 'wb_quiz_questions.php';
	}
	require($question_file[0]);

/*
	Let's check if we're evaluating or asking questions///
*/
	
	if (!isset($_POST['evaluate'])) {
		wb_quiz_ask_questions();
	}
	else {
		wb_quiz_evaluate();
	}

}
?>
