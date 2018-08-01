<?php

$I = new AcceptanceTester($scenario);
$I->wantToTest("the default behavior without any modifications");

//Given:
$I->expect('the new comment consent checkbox to be there, but cookies not activated.');
$I->setPluginState($I, "{default}");
$I->see("Save my name, email, and website in this browser for the next time I comment.");
//$I->amOnPage("/test-post");

//When:
$I->fillInCommentForm($I);
$I->click('Post Comment');

//Then:
$nameInCommentFieldAfterSubmission = $I->grabValueFrom('input[name=author]');
$I->expect("My name shouldn't be there, because I hadn't clicked the consent form. This is the default behavior.");
$I->assertNotEquals("John Dee", $nameInCommentFieldAfterSubmission);

//When:
$I->fillInCommentForm($I);
$I->checkOption('form input[name="wp-comment-cookies-consent"]');
$I->click('Post Comment');

//Then:
$I->expect("my name should be there, because I checked the box");
$nameInCommentFieldAfterSubmission = $I->grabValueFrom('input[name=author]');
$I->assertEquals("John Dee", $nameInCommentFieldAfterSubmission);


//When:
$comment = 'This is a test comment. Please delete me!' . (md5(uniqid(mt_rand(), true)));
$I->fillField('comment', $comment);
$I->click('Post Comment');

//Then:
$I->expect("my name should be there, because I checked the box");
$I->assertEquals("John Dee", $nameInCommentFieldAfterSubmission);