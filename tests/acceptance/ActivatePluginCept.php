<?php

//Given:
$I = new AcceptanceTester($scenario);

//When:
$I->loginAsAdmin();
$I->amOnPage("/wp-admin/plugins.php");
$I->deactivatePlugin('better-privacy');
$I->activatePlugin('better-privacy');

//Then:
//this is the "privacy" page:
$I->amOnPage("/wp-admin/options-general.php?page=values.php");

$checkBox = $I->grabAttributeFrom("#allow-comments-privacy", "checked");
$I->assertEquals($checkBox, "true", "The checkbox is there.");