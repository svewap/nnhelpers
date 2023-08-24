<?php 

return [
	'frontend' => [
		// Enrich the response
		'nnhelpers/resolver' => [
			'target' => \Nng\Nnhelpers\Middleware\ModifyResponse::class,
			'before' => [
				'typo3/cms-frontend/content-length-headers',
			],
			'after' => [
				'typo3/cms-frontend/shortcut-and-mountpoint-redirect',
			],
		]
	]
];