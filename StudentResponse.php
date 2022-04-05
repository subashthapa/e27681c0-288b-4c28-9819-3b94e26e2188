<?php
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
    public $responses;

    function __construct() {
        $studentResponses = json_decode(file_get_contents('./data/student-responses.json'), true);
    }

    function set_responseId($responseId) {
        $this->responseId = $responseId;
    }

    function set_assessmentId($assessmentId) {
        $this->assessmentId = $assessmentId;
    }

    function set_assigned($assigned) {
        $this->assigned = $assigned;
    }

    function set_started($started) {
        $this->started = $started;
    }

    function set_completed($completed) {
        $this->completed = $completed;
    }

    function set_studentId($studentId) {
        $this->studentId = $studentId;
    }

    function set_questionId($questionId) {
        $this->questionId = $questionId;
    }

    function set_response($response) {
        $this->response = $response;
    }

    function get_responseId() {
        return $this->responseId;
    }

    function get_assessmentId() {
        return $this->assessmentId;
    }

    function get_assigned() {
        return $this->assigned;
    }

    function get_started() {
        return $this->started;
    }

    function get_completed() {
        return $this->completed;
    }

    function get_studentId() {
        return $this->studentId;
    }

    function get_questionId() {
        return $this->questionId;
    }

    function get_response() {
        return $this->response;
    }

    /**
     * Get all response by students
     */
    public static function getAllResponses() {
        return json_decode(file_get_contents('./data/student-responses.json'), true);
    }

    /**
     * Get response by student id
     * @param $studentId - student id
     */
    function getResponseByStudentId($studentId) {
        $response = [];
        foreach(self::getAllResponses() as $studentResponse) {
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
    function getResponseByStrand($strand) {
        $response = [];
        $numeracy = 0;
        $measurement = 0;
        $statistics = 0;
    }

    /**
     * Get last attempted assessment
     */
    function getLastAttemptedAssessment($studentId) {
        $assessments = self::getResponseByStudentId($studentId);
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