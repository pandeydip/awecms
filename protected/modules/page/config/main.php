<?php

return array(
    'import' => array(
        'application.modules.page.models.*',
        'application.modules.page.behaviors.*',
        'application.modules.page.widgets.*',
    ),
    'components' => array(
        'urlManager' => array(
            'rules' => array(
                'feed' => 'page/feed',
            ),
        ),
    ),
);
