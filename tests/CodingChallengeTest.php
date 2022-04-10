<?php
use App\Main;
use \PHPUnit\Framework\TestCase;

class CodingChallengeTest extends TestCase {
    /**
     * Test diagnostic
     */
    public function testDiagnostic() {
        // call class
        $main = new Main();
        // define student
        $student = "student1";
        // call function
        $diagnostic = $main->diagnostic($student);
        // if the function throws no error,
        // test is passed
        $this->assertNull($diagnostic);
    }

    /**
     * Test feedback
     */
    public function testFeedback() {
        $expected = true;
        // call class
        $main = new Main();
        // define student
        $student = "student2";
        // call function
        $feedback = $main->feedback($student);
        // if the function throws no error,
        // test is passed
        $this->assertNull($feedback);
    }

    /**
     * Test progress
     */
    public function testProgressReport() {
        $expected = true;
        // call class
        $main = new Main();
        // define student
        $student = "student2";
        // call function
        $progress = $main->progressReport($student);
        // if the function throws no error,
        // test is passed
        $this->assertNull($progress);
    }
}