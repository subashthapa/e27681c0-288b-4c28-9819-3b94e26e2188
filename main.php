<?php
/**
 * Loading different classes
 */
require_once('./helpers/JsonReader.php');
require_once('./Student.php');
require_once('./Assessment.php');
require_once('./Question.php');
require_once('./StudentResponse.php');

 /**
  * Get input from user and give response based on csv file
  * 1. Ask users to enter student ID or esc to exit
  * 2. Ask user to 1 for Diagnostic, 2 for Progress, 3 for Feedback 
  */
function start() {
    echo "---------------------------------------------\n";
    echo "Please enter the student ID or 'esc' to exit: \n";
    $studentId = trim(fgets(STDIN));
    checkInput($studentId);

    echo "-------------------------\n";
    echo "Please enter 1 for Diagnostic, 2 for Progress, 3 for Feedback: \n";
    $selection = trim(fgets(STDIN));
    checkInput($studentId);

    switch($selection) {
        case 1:
            echo "Diagnostic selected \n";
            diagnostic($studentId);
            exit;
        case 2:
            echo "Progress selected \n";
            progressReport($studentId);
            exit;
        case 3:
            echo "Feedback selected \n";
            feedback($studentId);
            exit;
        default:
        exit;
    }
}

/**
 * Check if user wants to exit
 */
function checkInput($input) {
    if(trim($input) == 'esc'){
        echo "ABORTING!\n";
        exit;
    }
}

/**
 * Progress report
 */
function progressReport($studentId) {
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

}

/**
 * Diagnostic report
 */
function diagnostic($studentId) {
    // Find the student and student's correct answers
    // Example: student1
    $number = 0;
    $totalNumberQ = 0;
    $measurement = 0;
    $totalMeasurementQ = 0;
    $statistics = 0;
    $totalStatisticsQ = 0;

    $students = new Student();
    $assessments = new Assessment();
    $questions = new Question();
    $responses = new StudentResponse();

    $currentStudent = $students->getStudentById($studentId);  
    echo $currentStudent['firstName']." ".$currentStudent['lastName']." recently completed ";  
    
    $studentAssessment = $assessments->getAllAssessments();
    echo $studentAssessment[0]['name']." assessment on ";

    $studentResponses = $responses->getResponseByStudentId($studentId);
    echo $studentResponses[0]['completed']."\n";
    // WIP
    // echo date('F j Y h:i:s', strtotime($studentResponses[0]['started']))."\n";

    // $questions = $questions->getQuestionsByStudentId($studentId);
    // print_r($studentResponses);
    // exit;
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
            
            // switch($question['strand']){

            // }
        }

    }
    echo "He got ".($number + $measurement + $statistics)." questions right out of ".($totalNumberQ + $totalMeasurementQ + $totalStatisticsQ).".\n";
    echo "Details by strand given below:\n";
    echo "Numeracy and Algebra: ".$number." out of ".$totalNumberQ." correct\n";
    echo "Measurement and Geometry: ".$measurement." out of ".$totalMeasurementQ." correct\n";
    echo "Statistics and Probability: ".$statistics." out of ".$totalStatisticsQ." correct\n"; 
    exit;


}

/**
 * Feedback report
 */
function feedback($studentId) {
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
}


// Beginning of application
/**
 * Main 
 */
start();

?>