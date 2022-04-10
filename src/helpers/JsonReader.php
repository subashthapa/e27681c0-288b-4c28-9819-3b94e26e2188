<?php
/**
 * Read JSON file
 */
class JsonReader {

    private $assessments;
    private $students;
    private $questions;
    private $studentResponses; 

    /**
     * Return json data
     */
    public function getAssessments() {
        $assessments = file_get_contents('./data/assessments.json');
        return json_decode($assessments, true);
    }
    
    /**
     * Return json data
     */
    public function getQuestions() {
        $questions = file_get_contents('./data/questions.json');
        return json_decode($questions, true);
    }

    /**
     * Return json data
     */
    public function getStudents() {
        $students = file_get_contents('./data/students.json');
        return json_decode($students, true);
    }

    /**
     * Return json data
     */
    public function getStudentResponses() {
        $studentResponses = file_get_contents('./data/student-responses.json');
        return json_decode($studentResponses, true);
    }
}