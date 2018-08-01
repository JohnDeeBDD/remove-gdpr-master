# WordPress Snapshot Assertions

*Snapshot testing of WordPress code for PHPUnit, based on the [PHPUnit Snapshot Assertions package by Spatie](https://github.com/spatie/phpunit-snapshot-assertions).*

[![Build Status](https://travis-ci.org/lucatume/wp-snapshot-assertions.svg?branch=master)](https://travis-ci.org/lucatume/wp-snapshot-assertions)

## Installation
```bash
composer require lucatume/wp-snapshot-assertions --dev
```

## Usage
Snapshot testing comes very handy when testing the HTML output of some WordPress generated and managed code.  
In such instances WordPress will often generate time-dependent values, like nonces, and full URLs, like image sources.  
Those environment and time related differences might break a snapshot for the wrong reasons; e.g. the snapshot was generated on one machine (say locally) and ran on another machine where WordPress might be served at another URL and the test will surely run at a different time (say CI).  
For that purpose the `WPHtmlOutputDriver` driver was born:

```php
use Spatie\Snapshots\MatchesSnapshots;
use tad\WP\Snapshots\WPHtmlOutputDriver;

class MySnapshotTest extends \Codeception\TestCase\WPTestCase {
	use MatchesSnapshots;

	/**
	* Test snapshot for render
	*/
	public function test_snapshot_render() {
		// from some environment variable
		$currentWpUrl = getenv('WP_URL');
		$snapshotUrl = 'http://wp.localhost';
		
		$driver = new WPHtmlOutputDriver($currentWpUrl, $snapshotUrl);
		
		$sut = new MyPluginHTMLRenderingClass();
		
		// create a random post and return its post ID
		$postId= $this->factory->post->create();
		
		$renderedHtml = $sut->renderHtmlFor($postId);
      		$driver->setTolerableDifferences([$postId]);
		$driver->setTolerableDifferencesPrefixes(['post_', 'post-']);
		$driver->setTolerableDifferencesPostfixes(['-single', '-another-postfix']);
		
		$this->assertMatchesSnapshot($renderedHtml, $driver);
	}
}
```

By default the driver will lok for time-dependent fields with an `id`, `name` or `class` from a default list (e.g. `_wpnonce`); you might want to add or modify that list using the `WPHtmlOutputDriver::setTimeDependentKeys` method.  
On the same note, the driver will look for some attributes when looking to replace the snapshot URL with the current URL; you can modify those using the `WPHtmlOutputDriver::setUrlAttributes` method.  
Very often WordPress HTML will contain attributes and strings that will inline post IDs, titles and other fields; in general the comparison of the snapshots should not fail because the random post ID used when the snapshot was generated was `23` but it's, in another test run, `89`.  
To avoid that use the `WPHtmlOutputDriver::setTolerableDifferences` method to define what values defined in the current test run should not trigger a failure (see example above); furthermore run-dependent variables could be used to construct `id`, `class`, `data` and other attributes: if you know that the rendered HTML will contain something like this (where `23` is the post ID):

```html
<div class="post-23" data-one="23-postfix" data-two="prefix-23">
  <p>Foo</p>
</div>
```

You might want to say to the driver that the current post ID is a tolerable difference even when prefixed with `prefix-` or postfixed with `-postfix`:

```php
$driver->setTolerableDifferences([$currentPostId]);
$driver->setTolerableDifferencesPrefixes(['prefix-']);
$driver->setTolerableDifferencesPostfixes(['-postfix']);
$this->assertMatchesSnapshot($renderedHtml, $driver);
```
