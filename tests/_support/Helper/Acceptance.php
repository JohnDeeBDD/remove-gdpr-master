<?php
namespace Helper;

class Acceptance extends \Codeception\Module{
 
    public function resetPlugin($I){
        $I->loginAsAdmin();
        $I->amOnPage("/wp-admin/plugins.php");
        $I->deactivatePlugin('better-privacy');
        $I->activatePlugin('better-privacy');
 
    }
    
    public function logout($I){
        $I->amOnPage("/wp-login.php?action=logout");
        $I->click('log out');
        $I->see('You are now logged out.');
    }
    
    public function setPluginState($I, $state){
        //There are four possible settings.
        if ($state == "{default}"){
            $I->resetPlugin($I);
        }
        if ($state == "DO NOT Display user cookie consent checkbox in comments and opt-in"){
            $I->resetPlugin($I);
            $I->amOnPage("/wp-admin/options-general.php?page=values.php");
            $I->unCheckOption('form input[name="allow-comments-privacy"]');
            $I->click('Save Changes');
        }
        if($state == "DO NOT Display user cookie consent checkbox in comments and opt-out"){
            $I->resetPlugin($I);
            $I->amOnPage("/wp-admin/options-general.php?page=values.php");
            $I->unCheckOption('form input[name="allow-comments-privacy"]');
            $I->click('#gdpr-comment-opt-in-false');
            $I->click('Save Changes');
        }
        
        $I->logout($I);
        $I->amOnPage("/test-post");
    }
    
    public function fillInCommentForm($I){
        //Some data:
        $name = "John Dee";
        //You need to submit a random string to prevent duplicate test posts if they are backing up:
        $comment = 'This is a test comment. Please delete me!' . (md5(uniqid(mt_rand(), true)));
        $email = 'johndeebdd@gmail.com';
        
        $url = 'https://wp-bdd.com';
            $I->fillField('comment', $comment);
            $I->fillField('author', $name);
            $I->fillField('email', $email);
            $I->fillField('url', $url);
    }
}
