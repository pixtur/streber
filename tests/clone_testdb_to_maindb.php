<?php
/**
* This clones the content of the fixture database to the primary database.
*
* WARNING:
* - All changes to this database will be lost!
*
* This is required for updating the fixture database in case heavy db-changes
* are done to the database scheme.
*/
error_reporting (E_ALL);
require_once('simpletest/web_tester.php');
require_once('simpletest/reporter.php');

/**
* test installation
*/
### create a function to make sure we are starting at index.php ###
function startedIndexPhp() {return true; }

### include some core libraries ###
require_once('../std/common.inc.php');
require_once(dirname(__FILE__) . '/../conf/conf.inc.php');
require_once(dirname(__FILE__) . '/class.test_environment.php');

confChange('DB_TABLE_PREFIX_UNITTEST', '');   # overwrite development database!!!

TestEnvironment::prepare('fixtures/project_setup.sql');

header( 'Location: install/install.php' ) ;

?>