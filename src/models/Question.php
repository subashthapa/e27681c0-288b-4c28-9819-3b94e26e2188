<?php
namespace App\Models;
/**
 * Question class
 * fields: questionId, stem, type, strand, optionKey, hint
 * 
 */
 
class Question {
    public $questionId;
    public $stem;
    public $type;
    public $strand;
    public $optionKey;
    public $hint;
    // using different approach
    public $allQuestions;

    public function __construct() {
        $this->allQuestions = json_decode(file_get_contents('./data/questions.json'), true);
    }

    /**
     * Get single question
     * @param $qsId - question id
     */
    public function getQuestionById($qsId) {
        foreach($this->allQuestions as $question) {
            if($question['id'] == $qsId) {
                return $question;
                break;
            }
        }
    }

    /**
     * Check answer
     */
    function checkAnswer($question, $answer) {
        $quest = $this->getQuestionById($question);

        if($quest['config']['key'] == $answer) {
            $quest["result"] = "Correct";
            return $quest;
        } elseif($quest['config']['key'] != $answer) {
            $quest["result"] = "Incorrect";
            return $quest;
        } else {
            // Set result to answer from question
            $quest["result"] = $quest['config']['key'];
        }
    }
}