<?php
namespace App;
/**
 * Load helpers and classes
 */
use App\Models\Student;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\StudentResponse;

// Beginning of application
/**
 * Main 
 */
class Main {

    /**
     * Get input from user and give response based on csv file
    * 1. Ask users to enter student ID or esc to exit
    * 2. Ask user to 1 for Diagnostic, 2 for Progress, 3 for Feedback 
    */
    public function start() {
        echo "---------------------------------------------\n";
        echo "Please enter the student ID or 'esc' to exit: \n";
        $studentId = trim(fgets(STDIN));
        $this->checkInput($studentId);

        echo "-------------------------\n";
        echo "Please enter 1 for Diagnostic, 2 for Progress, 3 for Feedback: \n";
        $selection = trim(fgets(STDIN));
        $this->checkInput($studentId);

        switch($selection) {
            case 1:
                echo "Diagnostic selected \n";
                echo "-------------------------\n";
                $this->diagnostic($studentId);
                // Uncomment the call to start() function 
                // to start application again
                // $this->start();
                exit;
            case 2:
                echo "Progress selected \n";
                $this->progressReport($studentId);
                echo "-------------------------\n";
                // Uncomment the call to start() function 
                // to start application again
                // $this->start();
                exit;
            case 3:
                echo "Feedback selected \n";
                echo "-------------------------\n";
                $this->feedback($studentId);
                // Uncomment the call to start() function 
                // to start application again
                // $this->start();
                exit;
            default:
            exit;
        }
    }

    /**
     * Check if user wants to exit
     */
    public function checkInput($input) {
        if(trim($input) == 'esc'){
            echo "ABORTING!\n";
            exit;
        }
    }

    /**
     * Progress report
     */
    public function progressReport($studentId) {
        try {
            $students = new Student();
            $responses = new StudentResponse();
            // Get student
            $currentStudent = $students->getStudentById($studentId);
            // get student's response
            $studentResponses = $responses->getResponseByStudentId($studentId);
            // Get total number of attempts
            echo $currentStudent['firstName']." ".$currentStudent['lastName']." has completed Numeracy assessment ".count($studentResponses)." times in total. Date and raw score given below:\n\n";
            foreach($studentResponses as $response){
                if(isset($response['completed'])){
                    echo "Date: ".$response['completed'].", Raw score: ".$response['results']['rawScore']." out of ".count($response['responses'])."\n";
                }
            }
        } catch(Exception $e) {
            return "Failed message: Progress report failed \n".$e->getMessage();
        }
    }

    /**
     * Diagnostic report
     */
    public function diagnostic($studentId) {
        try {
            // Find the student and student's correct answers
            // Example: student1
            $number = 0;
            $totalNumberQ = 0;
            $measurement = 0;
            $totalMeasurementQ = 0;
            $statistics = 0;
            $totalStatisticsQ = 0;
            
            // Calling classes
            $students = new Student();
            $assessments = new Assessment();
            $questions = new Question();
            $responses = new StudentResponse();
            
            // Get current student
            $currentStudent = $students->getStudentById($studentId);  
            echo $currentStudent['firstName']." ".$currentStudent['lastName']." recently completed ";  
            
            // Using first assessment from file
            $studentAssessment = $assessments->allAssessments;
            echo $studentAssessment[0]['name']." assessment on ";
            
            // Get student responses
            $studentResponses = $responses->getResponseByStudentId($studentId);
            echo $studentResponses[0]['completed']."\n";
            
            // WIP
            // echo date('F j Y h:i:s', strtotime($studentResponses[0]['started']))."\n";
            foreach($studentResponses as $studentResponse){
                foreach($studentResponse['responses'] as $response){
                    // get question
                    $question = $questions->getQuestionById($response['questionId']);
                    
                    // check answer
                    // TDD - Use switch statement
                    if($question['strand'] == 'Number and Algebra') {
                        if($question['config']['key'] == $response['response']) {
                            $number += 1;
                        }
                        $totalNumberQ += 1;
                    }
                    if($question['strand'] == 'Measurement and Geometry') {
                        if($question['config']['key'] == $response['response']) {
                            $measurement += 1;
                        }
                        $totalMeasurementQ += 1;
                    }
                    if($question['strand'] == 'Statistics and Probability') {
                        if($question['config']['key'] == $response['response']) {
                            $statistics += 1;
                        }
                        $totalStatisticsQ += 1;
                    }
                }
            }
            echo "He got ".($number + $measurement + $statistics)." questions right out of ".($totalNumberQ + $totalMeasurementQ + $totalStatisticsQ).".\n";
            echo "Details by strand given below:\n";
            echo "Numeracy and Algebra: ".$number." out of ".$totalNumberQ." correct\n";
            echo "Measurement and Geometry: ".$measurement." out of ".$totalMeasurementQ." correct\n";
            echo "Statistics and Probability: ".$statistics." out of ".$totalStatisticsQ." correct\n"; 

        } catch(Exception $e) {
            return "Failed message: Diagnostic report failed \n".$e->getMessage();
        }
    }

    /**
     * Feedback report
     */
    public function feedback($studentId) {
        try {
            $students = new Student();
            $question = new Question();
            $responses = new StudentResponse();
            $assessments = new Assessment();

            // Get student
            $currentStudent = $students->getStudentById($studentId);

            // get student's response
            $studentResponses = $responses->getLastAttemptedAssessment($studentId);
            // print_r($studentResponses);
            // echo '---\n';
            // get assessment name
            $assessmentName = $assessments->getAssessmentById($studentResponses['assessmentId']);

            // print student's attempt
            // Need to work on date formatting
            echo $currentStudent['firstName']." ".$currentStudent['lastName']." recently completed ".$assessmentName['name']." assessment on  ".$studentResponses['completed']."(16th December 2021 10:46 AM)\n";
            echo "He got ".$studentResponses['results']['rawScore']." questions right out of ".count($studentResponses['responses']).". Feedback for wrong answers given below\n";
            
            // find incorrect answers
            foreach($studentResponses['responses'] as $res){
                $checkedQuestion = $question->checkAnswer($res['questionId'], $res['response']);
                if(isset($checkedQuestion['result']) && $checkedQuestion['result'] == "Incorrect") {
                    echo "-------------------------\n";
                    echo "Question: ".$checkedQuestion['stem']."\n";
                    echo "Your answer: ".$res['response']."\n";
                    echo "Right answer: ".$checkedQuestion['config']['key']."\n";
                    echo "Hint: ".$checkedQuestion['config']['hint']."\n";
                }
            }
        } catch(Exception $e) {
            return "Failed message: Feedback report failed \n".$e->getMessage();
        }
    }
}