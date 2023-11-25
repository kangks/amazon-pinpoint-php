<?php
require 'vendor/autoload.php';

use Aws\Exception\AwsException;
use Aws\Pinpoint\PinpointClient;

$configurations = include (dirname(__FILE__).'/config/pinpointclient-config.php');

$pinpointClient = new Aws\Pinpoint\PinpointClient($configurations['settings']);

$applicationId = $configurations['default']['applicationId'];
?>

<?php
$appResult = $pinpointClient->getApp([
    'ApplicationId' => $applicationId
]);
echo('<pre>' . print_r($appResult, true) . '</pre>');
?>
<br/>

<?php
# The "From" address. This address has to be verified in Amazon Pinpoint in the region you're using to send email.
$SENDER = $configurations['default']['sender'];

# The addresses on the "To" line. If your Amazon Pinpoint account is in the sandbox, these addresses also have to be verified.
$TOADDRESS = $configurations['default']['recipients'];

$TEMPLATENAME = $configurations['default']['templateName'];
$TEMPLATEVERSION = $configurations['default']['templateVersion'];
?>

<form method="post"> 

From: <input type="text" name="SENDER" value="<?php echo $SENDER;?>">
To: <input type="text" name="TOADDRESS" value="<?php echo $TOADDRESS;?>">

<input type="radio" name="content" value="simple">Simple
<input type="radio" name="content" value="template">Template

<input type="submit" name="send" value="Send Email"/> 
</form> 

<br/>
<br/>

<?php
// https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-pinpoint-2016-12-01.html#sendmessages

if(isset($_POST['send'])) { 

    $selected_content = $_POST['content'];

    $SENDER = $_POST['SENDER'];
    $TOADDRESS = $_POST['TOADDRESS'];

    $request = [
        'ApplicationId' => $applicationId,
        'MessageRequest' => [
            'Addresses' => [
                $TOADDRESS => [
                    'ChannelType' => 'EMAIL',
                ]
            ],
            'MessageConfiguration' => [
                'EmailMessage' => [
                    'FromAddress' => $SENDER,
                ]
            ]
        ]
    ];

    if ($selected_content == 'simple') {

        $request['MessageRequest']['MessageConfiguration']['EmailMessage']['SimpleEmail'] = [
            'HtmlPart' => [
                'Charset' => 'utf8',
                'Data' => 'click <a href="https://doit.com/">here</a>',
            ],
            'Subject' => [
                'Charset' => 'utf8',
                'Data' => 'from PinpointClient sendMessages'
            ]
            ];
        
    } else if ($selected_content == 'template') {
        
        $request['MessageRequest']['TemplateConfiguration'] = [
            'EmailTemplate' => [
                'Name' => $TEMPLATENAME,
                'Version' => $TEMPLATEVERSION,
            ],                    
        ];
    };

    try {
        $result = $pinpointClient->sendMessages(
            $request
        );    
        echo('<pre>' . print_r($result, true) . '</pre>');
    
    } catch (AwsException $e){
        error_log($e->getMessage());
    }
}     
?>

