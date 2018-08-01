<?php

namespace tad\WP\Snapshots;

function dataDir($path = null) {
	$dataRoot = __DIR__ . '/data';

	return $path === null ? $dataRoot : $dataRoot . '/' . ltrim($path, '/');
}
