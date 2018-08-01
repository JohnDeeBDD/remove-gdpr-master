<?php

class GdprCommentFormFeatureRemoverTest extends \Codeception\TestCase\WPTestCase{

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable(){
	    $GdprRollbackFeatures = new GdprRollbackFeatures\GdprCommentFormFeatureRemover();
	}
}