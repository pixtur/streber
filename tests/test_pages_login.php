<?php


/**
* intergration-tests
*
* This test-file is been used by testsuite_pages.php
* All Functions defined in TestPagesAll which start with "test" will be
* tested.
*
*/
class TestPagesLogin extends WebTestCase {
    
    /**
    * ignore test 
    */
    function testHomepage() {

        ### logout first ###
        $this->assertTrue($this->get('http://localhost/streber-alpha/index.php?go=logout'), 'getting logout-page (%s)' );
        $this->assertNoUnwantedPattern('/<b>Warning<\/b>:|<b>Error<\/b>:|<b>Notice<\/b>:/i',    'php-error found (%s)' );
        $this->assertNoUnwantedPattern('/class=notice/',                                         'check for streber warnings (%s)');
        $this->assertWantedPattern('/please login/i',                                            'check content (%s)');
        $this->assertValidHtmlStucture('login');

        ### test license ###
        $this->assertTrue($this->clickLink('License'),                                          'click at license');
        $this->assertNoUnwantedPattern('/<b>Warning<\/b>:|<b>Error<\/b>:|<b>Notice<\/b>:/i',    'php-error found (%s)' );
        $this->assertNoUnwantedPattern('/class=notice/',                                         'check for streber warnings (%s)');
        $this->assertTitle('License',                                                           'check title is license (%s)');
        

        ### be sure we cannot login ###
        $this->get('http://localhost/streber-alpha/index.php?go=sdf');

        $this->assertNoUnwantedPattern('/<b>Warning<\/b>:|<b>Error<\/b>:|<b>Notice<\/b>:/i',    'php-error found (%s)' );
        $this->assertNoUnwantedPattern('/class=notice/',                                         'check for streber warnings (%s)');
        
        ### enter login-infos ###
        $this->assertTrue( $this->setField('login_name', 'Admin'));
        $this->assertTrue( $this->setField('login_password', '') );

        ### submit -> login to home ###
        $this->assertTrue( $this->clickSubmit('Submit'));
        $this->assertNoUnwantedPattern('/<b>Warning<\/b>:|<b>Error<\/b>:|<b>Notice<\/b>:/i',    'php-error found (%s)' );
        $this->assertNoUnwantedPattern('/class=notice/',                                         'check for streber warnings (%s)');

        $this->assertWantedPattern('/home/i',                                            'check content (%s)');
        #$this->assertNoUnwantedPattern('Welcome to streber',         'title dummy (%s)');
        

    }
}
?>