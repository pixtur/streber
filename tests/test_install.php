<?php

function saveOriginalConfiguration()
{
	$result= rename('../_settings', '../_settings3');     # surpressing FILE-EXISTs notice
}

/**
* intergration-tests for login-logic and password changes/validation
*
* This test-file is been used by testsuite_pages.php
* All Functions defined in TestPagesAll which start with "test" will be
* tested.
*
*/
class TestInstall extends WebTestCase {
    
    function testInstallation() {

        #saveOriginalConfiguration();
        
        TestEnvironment::prepare('fixtures/project_setup.sql');
        $this->addHeader('USER_AGENT: streber_unit_tester');
        #
        #$g_streber_url= "http://localhost/streber_head";
        #
        #### logout first ###
        #$this->assertTrue($this->get("$g_streber_url/index.php?go=logout"), 'getting logout-page (%s)' );
        #
        #### test license ###
        #$this->assertTrue($this->clickLink('License'),                                          'click at license');
        #$this->assertTrue( $this->setField('login_name', 'admin'));
        #$this->assertTrue( $this->setField('login_password', 'wrong') );
        #$this->assertTrue( $this->clickSubmit('Submit'));
        #$this->assertWantedPattern('/invalid login/i',                                            'check content (%s)');
        #
        #### submit -> login to home ###
        #$this->assertNoUnwantedPattern('/<b>Warning<\/b>:|<b>Error<\/b>:|<b>Notice<\/b>:/i',    'php-error found (%s)' );

    }
}
?>