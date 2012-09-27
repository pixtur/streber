<?php
/**
* Simpletest suite for testing installation
*/
error_reporting (E_ALL);
require_once('simpletest/web_tester.php');
require_once('simpletest/reporter.php');

### create a function to make sure we are starting at index.php ###
function startedIndexPhp() {return true; }



### include some core libraries ###
require_once('../std/common.inc.php');
require_once(dirname(__FILE__) . '/../conf/conf.inc.php');
require_once(dirname(__FILE__) . '/class.test_environment.php');

#confChange('DB_TABLE_PREFIX_UNITTEST', '');   # overwrite development database!!!

TestEnvironment::prepare('fixtures/project_setup.sql');

$grouptest = new GroupTest('Item visibility');  $grouptest->addTestFile('test_item_visibility.php');    $grouptest->run(new HtmlReporter());
$grouptest = new GroupTest('Login logic');      $grouptest->addTestFile('test_pages_login.php');        $grouptest->run(new HtmlReporter());
$grouptest = new GroupTest('Render all pages'); $grouptest->addTestFile('test_pages_all.php');          $result= $grouptest->run(new HtmlReporter()); 

TestEnvironment::prepare('fixtures/remove_tables.sql');


?>