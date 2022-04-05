<?php
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
    public static $questions;

    function __construct() {
        $questions = json_decode(file_get_contents('./data/questions.json'), true);
    }

    function set_questionId($questionId) {
        $this->questionId = $questionId;
    }

    function set_stem($stem) {
        $this->stem = $stem;
    }

    function set_type($type) {
        $this->type = $type;
    }

    function set_strand($strand) {
        $this->strand = $strand;
    }

    function set_optionKey($optionKey) {
        $this->optionKey = $optionKey;
    }

    function set_hint($hint) {
        $this->hint = $hint;
    }

    function get_questionId() {
        return $this->questionId;
    }

    function get_stem() {
        return $this->stem;
    }

    function get_type() {
        return $this->type;
    }

    function get_strand() {
        return $this->strand;
    }

    function get_optionKey() {
        return $this->optionKey;
    }

    function get_hint() {
        return $this->hint;
    }

    /**
     * Get all questions
     */
    public static function getAllQuestions() {
        return json_decode(file_get_contents('./data/questions.json'), true);
    }

    /**
     * Get questions by strand
     * @param $strand - strand
     */
    function getQuestionsByStrand($strand) {
        $questions = [];
        foreach(self::getAllQuestions() as $question){
            if($question['strand'] == $strand){
                $questions[] = $question;
            }
        }
    }

    /**
     * Get single question
     * @param $qsId - question id
     */
    function getQuestionById($qsId) {
        foreach(self::getAllQuestions() as $question) {
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
        $quest = self::getQuestionById($question);
        // print_r($quest); echo '\nquest\n';
        if($quest['config']['key'] == $answer) {
            $quest["result"] = "Correct";
            return $quest;
        } elseif($quest['config']['key'] != $answer) {
            $quest["result"] = "Incorrect";
            return $quest;
        } else {
            $quest["result"] = $quest['config']['key'];
        }
    }
}