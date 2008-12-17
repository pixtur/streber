<?php

/**
* intergration-tests
*
* This test-file is been used by testsuite_pages.php
* All Functions defined in TestPagesAll which start with "test" will be
* tested.
*
*/
class TestPagesAll extends WebTestCase {
    
    
    /**
    *
    */
    function testAllPages() {

        TestEnvironment::prepare('fixtures/project_setup.sql');
        $this->addHeader('USER_AGENT: streber_unit_tester');
        
        /**
        * we require some valid logins and ids to test all pages
        */
        $login_name     = "admin";
        $login_password = "";
        $url_streber    = "http://localhost/streber_head/";
        $url_start      = $url_streber . 'index.php?go=logout';
        $test_params    = array(
                             "_projectView_"=>12,
                             "_projectEdit_"=>12,
                             "_taskView_"=>18,
                             "_taskEdit_"=>18,

                             "_personView_"=>1,
                             "_personEdit_"=>1,

                             "_companyView_"=>8,
                             "_companyEdit_"=>8,

                             "_commentView_"=>241,
                             "_commentEdit_"=>241,

                             "_effortView_"=>35,
                             "_effortEdit_"=>35,

                          );
        
        require_once("../conf/defines.inc.php");                # the order of those includes is tricky
        require_once('../std/class_auth.inc.php');

        require_once("../std/class_pagehandler.inc.php");
        require_once("../pages/_handles.inc.php");

        confChange('USE_MOD_REWRITE', false);		# uncomment this for apache 1.x
        
        /**
        * test all pagehandles for correct rendering
        */

        ### enter login-infos ###
        $this->assertTrue( $this->get($url_start)                   ,'getting logout-page (%s)' );
        $this->assertTrue( $this->setField('login_name', $login_name)   ,'set login-name (%s)');
        $this->assertTrue( $this->setField('login_password', $login_password)    ,'set password (%s)');
        
        ### submit -> login to home ###
        $this->assertTrue( $this->clickSubmit('Submit')             ,'click_submit');
        
        $this->assertNoUnwantedPattern('/invalid login/i'           ,'Login for testing working (%s)');

        ### go though all pagehandles and render ###
        foreach($PH->hash as $key=>$handle) {
            
            if($handle->test == 'yes') {

                TestEnvironment::prepare('fixtures/project_setup.sql');

                if(isset($handle->test_params)) {
                    $params=array();
                    foreach($handle->test_params as $param=>$value) {
                        if(isset($test_params[$value])){
                            #echo "using param $param=$test_params[$value]<br>";
                            $params[$param]= $test_params[$value];
                        }
                    }
                    $url= $url_streber . $PH->getUrl($key,$params);
                }
                else {
                    $url= $url_streber . $PH->getUrl($key);
                }
                echo "<b>$url</b><br>";
                $this->assertTrue($this->get($url)         , "getting $url (%s)");
                $this->assertNoUnwantedPattern('/PHP Error |<b>Fatal error<\/b>|<b>Warning<\/b>|<b>Error<\/b>|<b>Notice<\/b>|<b>Parse error<\/b>/i',    'php-error found (%s)' );
                $this->assertNoUnwantedPattern('/' . '%' . '%' . '/i',     'debug output found (%s)' );
                $this->assertValidHtmlStucture($url);
                $this->assertNoUnwantedPattern('/fatal error \(/i', 'check for streber warnings (%s)');
                $this->assertNoUnwantedPattern('/Error:/i', 'check for streber warnings (%s)');
                $this->assertWantedPattern('/<\/html>/',                                         'rendering Complete? (%s)');
                $this->assertNoUnwantedPattern('/<x>/',     'check unescaped data (%s)');
                $this->assertNoUnwantedPattern('/&amp;lt;x&amp;gt;/',     'check double escaped data (%s)');
                
                

                for($i=0;$i<20;$i++) {
                    echo "                       ";
                }

                #$this->assertNoUnwantedPattern('/class=notice/',                                         'check for streber warnings (%s)');
                #$this->assertTitle('XXX',         'title dummy (%s)');
                #$this->assertNoUnwantedPattern('/message/');
                #echo "title=".$this->webbrowser->getTitle();
            }
        }
    }
}
?>