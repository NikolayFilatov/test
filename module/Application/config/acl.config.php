<?php
return [
    'GeoAcl' => [
        'group' => [
            'guest' => [
                'permission' => ['deny', 'view', 'news', 'home']
            ],
            'user' => [
                'permission' => ['my', 'my/wall', 'my/sett', 'my/res', 'my/spec']
            ],
            'moderator' => [
                'permission' => ['edit']
            ],
            'admin' => [
                'permission' => []
            ],
        ]
    ]
];