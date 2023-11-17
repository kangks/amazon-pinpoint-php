<?php
require 'vendor/autoload.php';

use Aws\Exception\AwsException;
use Aws\PinpointEmail\PinpointEmailClient;

$settings = include (dirname(__FILE__).'/config/config.php');

$pinpointClient = new Aws\PinpointEmail\PinpointEmailClient($settings);
?>

<?php
# The "From" address. This address has to be verified in Amazon Pinpoint in the region you're using to send email.
$SENDER = "<sender email>";

# The addresses on the "To" line. If your Amazon Pinpoint account is in the sandbox, these addresses also have to be verified.
$TOADDRESS = "<receiver email>";
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
// https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-pinpoint-email-2018-07-26.html#sendemail

if(isset($_POST['send'])) { 

    $selected_content = $_POST['content'];

    $content = '';

    if ($selected_content == 'simple') {

        $content = array(
            'Simple' => [
                'FromAddress' => 'Sender',
                'Body' => [ // REQUIRED
                    'Html' => [
                        'Charset' => 'utf8',
                        'Data' => 'click <a href="https://doit.com/">here</a>', // REQUIRED
                    ]
                ],
                'Subject' => [ // REQUIRED
                    'Charset' => 'utf8',
                    'Data' => 'from Pinpoint', // REQUIRED
                ],
            ]);
        
    } else if ($selected_content == 'template') {
        
        $content = array(
            'Template' => [
                'TemplateArn' => 'arn:aws:mobiletargeting:<AWS region>:<AWS Account>:templates/template/EMAIL',
                'TemplateData' => json_encode (new stdClass)
            ]
        );        
    };

    try {
        $result = $pinpointClient->sendEmail([
            'Content' => 
                $content,
            'Destination' => [
                'ToAddresses' => [$TOADDRESS],
            ],
            'FromEmailAddress' => $SENDER
        ]);    
        print $result;
    
    } catch (AwsException $e){
        error_log($e->getMessage());
    }
}     
?>

