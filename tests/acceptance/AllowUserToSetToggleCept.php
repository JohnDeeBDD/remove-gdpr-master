<?php

$I = new AcceptanceTester($scenario);
$I->wantToTest("Make sure when the user clicks the box, it stays clicked");

//Given:
$I->expect('the new comment consent checkbox to be there, but cookies not activated.');
$I->setPluginState($I, "{default}");
$I->see("Save my name, email, and website in this browser for the next time I comment.");

//When:
$I->fillInCommentForm($I);
$I->checkOption('form input[name="wp-comment-cookies-consent"]');
$I->click('Post Comment');

//Then:
$nameInCommentFieldAfterSubmission = $I->grabValueFrom('input[name=author]');

$I->expect("My name should be there, because I have clicked the consent form.");
$I->assertEquals("John Dee", $nameInCommentFieldAfterSubmission);

//Do it again:
$I->fillInCommentForm($I);

//This time, uncheck check the box. It should already be checked!
$I->unCheckOption('form input[name="wp-comment-cookies-consent"]');
$I->click('Post Comment');

$I->expect("My name should NOT be there, because I have clicked the consent form and it should remain latent..");
$nameInCommentFieldAfterSubmission = $I->grabValueFrom('input[name=author]');
$I->assertNotEquals("John Dee", $nameInCommentFieldAfterSubmission);

$I->fillInCommentForm($I);
$I->checkOption('form input[name="wp-comment-cookies-consent"]');
$I->click('Post Comment');

//Then:
$nameInCommentFieldAfterSubmission = $I->grabValueFrom('input[name=author]');

$I->expect("My name should be there, because I have clicked the consent form.");
$I->assertEquals("John Dee", $nameInCommentFieldAfterSubmission);

$comment = 'This is a test comment. Please delete me!' . (md5(uniqid(mt_rand(), true)));
$I->fillField('comment', $comment);
$I->click('Post Comment');

$I->expect('The check box to remain checked because I clicked it last form submission');
$checkMarkValue = $I->grabAttributeFrom('input[name="wp-comment-cookies-consent"]', "checked");
$I->assertEquals("yes", $checkMarkValue, "VALUE : $checkMarkValue ***");


