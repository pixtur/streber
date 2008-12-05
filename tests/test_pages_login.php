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
    
    function testHomepage() {
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
        $this->assertWantedPattern('<body class="home">',  'check we are at home');
    }
}
?>