<?php

/**
* test item visibilty
*
* This test-file is been used by testsuite_pages.php
* All Functions defined in TestPagesAll which start with "test" will be tested.
*
*/
class TestEfforts extends WebTestCase {
    
    function testEffort() {
        global $g_streber_url;
        TestEnvironment::initStreberUrl();
        TestEnvironment::prepare('fixtures/project_setup.sql');
        $this->addHeader('USER_AGENT: streber_unit_tester');

        ### logout first ###
        $this->assertTrue($this->get($g_streber_url), 'getting login page (%s)' );
        $this->assertWantedPattern('/please login/i','check content (%s)');

        $this->assertValidHtmlStucture('login');


        ### Test login working ###
        $this->assertTrue( $this->setField('login_name', 'bob'));
        $this->assertTrue( $this->setField('login_password', 'bob_secret') );
        $this->assertTrue( $this->clickSubmit('Submit'));
        validatePage($this);
        
        $this->assertTrue($this->get($g_streber_url . "/index.php?go=projViewEfforts&prj=10"), 'getting project effort view (%s)' );
        validatePage($this);
        $this->assertTrue($this->get($g_streber_url . "/index.php?go=homeEfforts"), 'getting user efforts (%s)' );
        validatePage($this);

        $this->assertTrue($this->get($g_streber_url . "/index.php?go=effortNew&prj=10"), 'book new effort (%s)' );
        validatePage($this);
        $this->assertTrue( $this->setField('effort_name', 'bla2'));

        $this->assertTrue( $this->clickSubmit('Submit'));
        validatePage($this);

        

    }

}

?>