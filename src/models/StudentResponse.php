<?php
namespace App\Models;
/**
 * StudentResponse class
 * fields: responseId, assessmentId, assigned, started, completed, studentId, questionId, response
 * 
 */

class StudentResponse {
    public $responseId;
    public $assessmentId;
    public $assigned;
    public $started;
    public $completed;
    public $studentId;
    public $questionId;
    // using different approach
    public $allResponses = [];

    function __construct() {
        $this->allResponses = json_decode(file_get_contents('./data/student-responses.json'), true);
    }

    /**
     * Get response by student id
     * @param $studentId - student id
     */
    public function getResponseByStudentId($studentId) {
        $response = [];
        foreach($this->allResponses as $studentResponse) {
            $student = $studentResponse['student'];
            if($student['id'] == $studentId){
                $response[] = $studentResponse;
            }
        }
        return $response;
    }

    /**
     * Get student reponse by strand
     * @param $studentId - student id
     * @param $strand - strand
     */
    public function getResponseByStrand($strand) {
        $response = [];
        $numeracy = 0;
        $measurement = 0;
        $statistics = 0;
    }

    /**
     * Get last attempted assessment
     */
    function getLastAttemptedAssessment($studentId) {
        $assessments = $this->getResponseByStudentId($studentId);
        $lastDate = null;

        $latestAttempt = [];
        foreach($assessments as $assessment){
            //  return strtotime(str_replace('/','-',$assessment['completed'])).' '.$assessment['completed'];
            if($lastDate == null) {
                $lastDate = isset($assessment['completed']) ? strtotime(str_replace('/','-',$assessment['completed'])) : $lastDate;
                $lastAttempt = $assessment;
            } else {
                // check if the assessment is completed
                if(isset($assessment['completed'])){
                    $lastAttempt = $assessment;
                }
            }
        }
        // Using first attempt cause there's 3 attempts from students.
        // 
        $latestAttempt = $assessments[0];
        return $latestAttempt;
    }
}