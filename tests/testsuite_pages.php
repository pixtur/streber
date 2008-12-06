<?php
/**
* Simpletest suite for streberPM
*
* Some hints:
*   We use the simpletest as exmplained in the simple-test documentation:
*
*   1. include the testing-tools
*   2. create a new GroupTest
*   3. add test-file
*   4. run 
*
* This suite tests:
* - rendering of pages defined in pagehandle-list (see pages/_handles.inc)
*
* planned...
* - some basic login funcitionality
*
*/
error_reporting (E_ALL);

/**
* create a function to make sure we are starting at index.php
*/
function startedIndexPhp() {return true; }                     # define function 

require_once('simpletest/web_tester.php');
require_once('simpletest/reporter.php');

require_once('../std/common.inc.php');

require_once(dirname(__FILE__) . '/class.test_environment.php');

TestEnvironment::prepare('fixtures/project_setup.sql');

$grouptest = new GroupTest('Login logic');
$grouptest->addTestFile('test_pages_login.php');
$result= $grouptest->run(new HtmlReporter());

$grouptest = new GroupTest('Render all pagehandles');
$grouptest->addTestFile('test_pages_all.php');
$result= $grouptest->run(new HtmlReporter());

TestEnvironment::prepare('fixtures/remove_tables.sql');

if($result) {
    exit(0);
}
else{
    exit(1);
}

?>