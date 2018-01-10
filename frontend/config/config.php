<?php
return [
    'web' => [
        'url' => [
            [
                'class' => 'codex\web\UrlHelper'
            ],
            '/test' => '/controller/view'
        ],
        'session' => [
            'identity' => 'codex\web\Identity',
            'timeout' => 60 * 60
        ]
    ]
]
?>
