<?php

require_once dirname(__FILE__) . '/../agent.php';
require_once dirname(__FILE__) . '/../../phpunit/PHPUnit/Autoload.php';

//require_once '../phpunit/phpunit.php';
//require_once '../phpunit/PHPUnit/Framework.php';
//require_once 'PHPUnit...blah,blah,whatever';
//ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__) . '/../../phpunit');


class AgentTest extends PHPUnit_Framework_TestCase {

    private $agent;

    protected function setUp() {
        parent::setUp();
        $this->agent = new Agent();
    }

    protected function tearDown() {
        $this->agent = null;
        parent::tearDown();
    }

    public function __construct() {
        // not really needed
    }

    public function testGetThresholds() {
        $thresholds = $this->agent->getThresholds();
        
        $this->assertTrue(is_array($thresholds));
    }

    /**
     * Tests ClassYouWantToTest->methodFoo()
     */
    public function testGetUsers() {
        $this->assertTrue(
                is_array($this->agent->getUsers())
        );
    }

}

?>
