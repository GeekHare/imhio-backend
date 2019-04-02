<?php

use PHPUnit\Framework\TestCase;

/**
 * Class EmailTest
 */
class EmailTest extends TestCase {

    /**
     * @runInSeparateProcess
     */
    public function test_check_post_valid() {
        $Email = new \Api\objects\Email("POST", [
            "object" => "email",
            "method" => "check",
            "args" => ""
        ], "{\"email\":\"john@domain.local\"}");

        $this->assertIsObject($Email);
        $this->expectOutputString('{"validation":true,"code":200}');
    }

    /**
     * @runInSeparateProcess
     */
    public function test_check_post_invalid() {

        $Email = new \Api\objects\Email("POST", [
            "object" => "email",
            "method" => "check",
            "args" => ""
        ], "{\"email\":\"johndomain.local\"}");

        $this->assertIsObject($Email);
        $this->expectOutputString('{"err":"EMAIL_BAD","code":200}');
    }

    /**
     * @runInSeparateProcess
     */
    public function test_check_post_required() {

        $Email = new \Api\objects\Email("POST", [
            "object" => "email",
            "method" => "check",
            "args" => ""
        ], "{\"email\":\"\"}");

        $this->assertIsObject($Email);
        $this->expectOutputString('{"err":"EMAIL_REQUIRED","code":400}');
    }
}