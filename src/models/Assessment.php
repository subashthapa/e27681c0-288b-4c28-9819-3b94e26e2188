<?php
namespace App\Models;

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
    public $allAssessments = [];

    function __construct() {
        $this->allAssessments = json_decode(file_get_contents('./data/assessments.json'), true);
    }

    /**
     * Get assessment by id
     */
    public function getAssessmentById($asId) {
        foreach($this->allAssessments as $assessment) {
            if($assessment['id'] == $asId) {
                return $assessment;
                break;
            }
        } 
    }

    /**
     * Get question by assessment
     */
    public function getQuestionByAssessment($assessment, $question) {
        $questions = [];
        // loop through assessments
        foreach($allAssessments as $assessment) {
            // if there are multiple questions,
            // go through all of them and 
            // add them to $questions[] array
            if(count($assessment['questions'])>0) {
                foreach($assessment['questions'] as $question) {
                    $questions[] = $question;
                }
            }
        }

        return $questions;
    }
}