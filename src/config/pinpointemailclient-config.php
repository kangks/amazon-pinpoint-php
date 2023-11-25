<?php
return (
    array(
        'settings' => [
            'profile' => 'pinpoint',
            'region'  => 'us-east-1',
            'version'  => '2018-07-26',    
        ],
        'default' => [
            'senderFriendlyName' => '<friendly sender name>',
            'senderAddress' => '<sender email adddress>',
            'recipients' => '<recipient email address>',
            'templateArn' => 'arn:aws:mobiletargeting:us-east-1:<AWS Account ID>:templates/<template name>/EMAIL',
        ]
    ));    
?>