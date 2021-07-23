<?php 

if (\nn\t3::t3Version() < 10) {
	return [
		\Nng\Nnhelpers\Domain\Model\File::class => [
			'tableName' => 'sys_file',
			'recordType' => \Nng\Nnhelpers\Domain\Model\File::class,
			'properties' => [
				'storageUid' => [
					'fieldName' => 'storage',
				],
			],
		],
		\Nng\Nnhelpers\Domain\Model\FileReference::class => [
			'tableName' => 'sys_file_reference',
			'recordType' => \Nng\Nnhelpers\Domain\Model\FileReference::class,
			'properties' => [
				'file' => [
					'fieldName' => 'uid_local',
				],
			],
		],
	];
}

return [
	\Nng\Nnhelpers\Domain\Model\File::class => [
		'tableName' => 'sys_file',
		'properties' => [
			'storageUid' => [
				'fieldName' => 'storage',
			],
		],
	],
	\Nng\Nnhelpers\Domain\Model\FileReference::class => [
		'tableName' => 'sys_file_reference',
		'properties' => [
			'file' => [
				'fieldName' => 'uid_local',
			],
		],
	],
];