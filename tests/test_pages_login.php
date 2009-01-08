<?php

/**
* intergration-tests for login-logic and password changes/validation
*
* This test-file is been used by testsuite_pages.php
* All Functions defined in TestPagesAll which start with "test" will be
* tested.
*
*/
class TestPagesLogin extends WebTestCase {
    
    function testHomepage() {

        TestEnvironment::prepare('fixtures/project_setup.sql');
        $this->addHeader('USER_AGENT: streber_unit_tester');

        $g_streber_url= "http://localhost/streber_head";

        ### logout first ###
        $this->assertTrue($this->get("$g_streber_url/index.php?go=logout"), 'getting logout-page (%s)' );
        $this->assertNoUnwantedPattern('/<b>Warning<\/b>:|<b>Error<\/b>:|<b>Notice<\/b>:/i',    'php-error found (%s)' );
        $this->assertNoUnwantedPattern('/class=notice/',                                         'check for streber warnings (%s)');
        $this->assertWantedPattern('/please login/i',                                            'check content (%s)');
        $this->assertValidHtmlStucture('login');

        ### test license ###
        $this->assertTrue($this->clickLink('License'),                                          'click at license');
        $this->assertNoUnwantedPattern('/<b>Warning<\/b>:|<b>Error<\/b>:|<b>Notice<\/b>:/i',    'php-error found (%s)' );
        $this->assertNoUnwantedPattern('/class=notice/',                                         'check for streber warnings (%s)');
        $this->assertTitle('License/ - streber',                                                           'check title is license (%s)');


        ### be sure we cannot access protected pages without login ###
        $this->get("$g_streber_url/index.php?go=systemInfo");
        $this->assertNoUnwantedPattern('/System Info/i',    'php-error found (%s)' );
        $this->assertWantedPattern('/Please login/i',                                         'check for streber warnings (%s)');

        ### Test invalid login ###
        $this->assertTrue( $this->setField('login_name', 'admin'));
        $this->assertTrue( $this->setField('login_password', 'wrong') );
        $this->assertTrue( $this->clickSubmit('Submit'));
        $this->assertWantedPattern('/invalid login/i',                                            'check content (%s)');

        ### submit -> login to home ###
        $this->assertNoUnwantedPattern('/<b>Warning<\/b>:|<b>Error<\/b>:|<b>Notice<\/b>:/i',    'php-error found (%s)' );

        ### Test login working ###
        $this->assertTrue( $this->setField('login_name', 'admin'));
        $this->assertTrue( $this->setField('login_password', '') );
        $this->assertTrue( $this->clickSubmit('Submit'));
        $this->assertNoUnwantedPattern('/invalid login/i',                                            'check content (%s)');
        $this->assertNoUnwantedPattern('/<x>/');
        $this->assertWantedPattern('<body class="home">',  'check we are at home');

        ### logout  ###
        $this->assertTrue($this->get("$g_streber_url/index.php?go=logout"), 'getting logout-page (%s)' );
        $this->assertWantedPattern('/please login/i',                                            'check content (%s)');
        $this->assertValidHtmlStucture('login');
        
        ### login as pm ###
        $this->assertTrue( $this->setField('login_name', 'pm'));
        $this->assertTrue( $this->setField('login_password', 'wrong') );
        $this->assertTrue( $this->clickSubmit('Submit'));
        $this->assertNoUnwantedPattern('/<x>/');
        $this->assertWantedPattern('/invalid login/i',                                            'check content (%s)');

        $this->assertTrue( $this->setField('login_name', 'pm'));
        $this->assertTrue( $this->setField('login_password', 'pm_secret') );
        $this->assertTrue( $this->clickSubmit('Submit'));
        $this->assertNoUnwantedPattern('/<x>/');
        $this->assertNoUnwantedPattern('/invalid login/i',                                            'check content (%s)');

        $this->assertWantedPattern('<body class="home">',  'check we are at home');

        ###
        $this->assertTrue( $this->clickLink( 'Peter Manage <x>'));
        $this->assertWantedPattern( '<body class="personView">');
        $this->assertTrue( $this->clickLink('Edit profile'));

        ### can't save if not identical
        $this->assertTrue( $this->setField('person_password1',      'pm_secret'));
        $this->assertTrue( $this->setField('person_password2',      'pm_secret_different') );
        $this->assertTrue( $this->clickSubmit('Submit'));
        $this->assertNoUnwantedPattern('/<x>/');
        $this->assertWantedPattern('<body class="personEdit">',     'check we are still editing');

        ### save new password
        $this->assertTrue( $this->setField('person_password1',      'pm_secret_new'));
        $this->assertTrue( $this->setField('person_password2',      'pm_secret_new') );
        $this->assertTrue( $this->clickSubmit('Submit'));
        $this->assertNoUnwantedPattern('/<x>/');
        $this->assertNoUnwantedPattern('/<body class="personEdit">/',     'check we are still editing');
        $this->assertNoUnwantedPattern('<body class="personEdit">',     'check we are no longer editing');

        ### Try to login with new password
        $this->assertTrue( $this->clickLink('Logout'));
        $this->assertTrue( $this->setField('login_name', 'pm'));
        $this->assertTrue( $this->setField('login_password', 'pm_secret_new') );
        $this->assertTrue( $this->clickSubmit('Submit'));
        $this->assertNoUnwantedPattern('/<x>/');
        $this->assertNoUnwantedPattern('/invalid login/i',                                            'check content (%s)');
        $this->assertWantedPattern('<body class="home">',  'check we are at home');
        
        
        ### test all languages
        global $g_languages;
        foreach( $g_languages as $key => $language ) {
            $this->assertTrue( $this->clickLink( 'Peter Manage <x>'));
            $this->assertWantedPattern( '<body class="personView">');

            ### set language
            $this->assertTrue( $this->get("$g_streber_url/index.php?go=personEdit&person=2"), 'getting logout-page (%s)' );
            $this->assertTrue( $this->setField('person_language', $language) );
            if(!$this->assertTrue( $this->clickSubmitById('submitbutton'))) {
                $this->showSource();
            }
            validatePage($this);

            $this->assertNoUnwantedPattern('<body class="personEdit">',     'check we are no longer editing');
        }
        
    }
}
?>