<?php
namespace App\Models;
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
    public $allStudents = [];

    public function __construct() {
        $this->allStudents = json_decode(file_get_contents('./data/students.json'), true);
    }

    /**
     * Get single student
     * @param $stId - student id
     */
    
    public function getStudentById($stId) {
        foreach($this->allStudents as $student) {
            if($student['id'] == $stId) {
                return $student;
                break;
            }
        }
    }

}