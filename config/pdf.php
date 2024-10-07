<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => storage_path('app/temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'bangla' => [
			'R'  => 'SolaimanLipi.ttf',    // regular font
			'useOTL' => 0xFF,   
            'useKashida' => 75, 
		],
		'ko_bme' => [
			'R'  => 'BMEuljiro10yearslater.ttf',    // regular font
		],
		'vitro' => [
			'R'  => '비트로 프라이드 TTF.ttf',    // regular font
		],
		'vitro_p' => [
			'R'  => '비트로 코어 TTF.ttf',    // regular font
		]
	]
];
