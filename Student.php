<?php
/**
 * Student class
 * fields: studentId, firstName, lastName, yearLevel
 * 
 */

class Student {
    public $studentId;
    public $firstName;
    public $lastName;
    public $yearLevel;
    // using different approach
    public static $allStudents;

    function __construct() {
        $allStudents = json_decode(file_get_contents('./data/students.json'));
    }

    function set_studentId($studentId) {
        $this->studentId = $studentId;
    }

    function set_firstName($firstName) {
        $this->firstName = $firstName;
    }

    function set_lastName($lastName) {
        $this->lastName = $lastName;
    }

    function set_yearLevel($yearLevel) {
        $this->yearLevel = $yearLevel;
    }

    function get_studentId() {
        return $this->studentId;
    }

    function get_firstname() {
        return $this->firstName;
    }

    function get_lastname() {
        return $this->lastName;
    }

    function get_yearLevel() {
        return $this->yearLevel;
    }

    /**
     * Get all students
     */
    public static function getAllStudents() {
        return json_decode(file_get_contents('./data/students.json'), true);
    }

    /**
     * Get single student
     * @param $stId - student id
     */
    
    function getStudentById($stId) {
        foreach(self::getAllStudents() as $student) {
            if($student['id'] == $stId) {
                return $student;
                break;
            }
        }
    }

}