<?php
//not done
$I = new AcceptanceTester($scenario);
$I->wantToTest("that I can turn off the comment cookie consent addition. Selecting opt-in.");

//Given:
$I->setPluginState($I, "DO NOT Display user cookie consent checkbox in comments and opt-in");
$I->dontSee("Save my name, email, and website in this browser for the next time I comment.");

//When:
$I->fillInCommentForm($I);
$I->click('Post Comment');

//Then:
$nameInCommentFieldAfterSubmission = $I->grabValueFrom('input[name=author]');
$I->expect("my name should be there, because opted in automatically and removed the checkbox");
$I->assertEquals("John Dee", $nameInCommentFieldAfterSubmission);