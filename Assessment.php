<?php
/**
 * Assessment class
 * fields: assessmentId, numeracy, questionId
 * 
 */

class Assessment {
    public $assessmentId;
    public $numeracy;
    public $questionId;
    // using different approach
    public static $assessments;

    function __construct() {
        $assessments = json_decode(file_get_contents('./data/assessments.json'), true);
    }

    function set_assessmentId($assessmentId) {
        $this->assessmentId = $assessmentId;
    }

    function set_numeracy($numeracy) {
        $this->numeracy = $numeracy;
    }

    function set_questionId($questionId) {
        $this->questionId = $questionId;
    }

    function get_assessmentId() {
        return $this->assessmentId;
    }

    function get_numeracy() {
        return $this->numeracy;
    }

    function get_questionId() {
        return $this->questionId;
    }

    /**
     * Get all assessments
     */
    public static function getAllAssessments() {
        return json_decode(file_get_contents('./data/assessments.json'), true);
    }

    /**
     * Get assessment by id
     */
    function getAssessmentById($asId) {
        foreach(self::getAllAssessments() as $assessment) {
            if($assessment['id'] == $asId) {
                return $assessment;
                break;
            }
        } 
    }

    /**
     * Get question by assessment
     */
    function getQuestionByAssessment($assessment, $question) {
        $questions = [];

        foreach($assessments as $assessment) {
            if(count($assessment['questions'])>0) {
                foreach($assessment['questions'] as $question) {
                    $questions[] = $question;
                }
            }
        }

        return $questions;
    }
}