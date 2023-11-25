<?php
return (
    array(
        'settings' => [
            'profile' => 'pinpoint',
            'region'  => 'us-east-1',
            'version'  => '2018-07-26',    
        ],
        'default' => [
            'sender' => '<sender>',
            'recipients' => '<recipient>',
            'templateArn' => 'arn:aws:mobiletargeting:us-east-1:<AWS Account ID>:templates/<template name>/EMAIL'
        ]
    ));    
?>