<?php


return [
    'target_php_version' => '8.1',
    'directory_list' => [
        'src',
        'vendor/symfony/dom-crawler',
        'vendor/guzzlehttp/guzzle',
        'vendor/psr/http-message'
    ],
    'exclude_file_regex' => '@^vendor/.*/(tests?|Tests?)/@',
    'exclude_analysis_directory_list' => [
        'vendor/'
    ],
];