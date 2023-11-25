<?php
require 'vendor/autoload.php';

use Aws\Exception\AwsException;
use Aws\PinpointEmail\PinpointEmailClient;

$configurations = include (dirname(__FILE__).'/config/pinpointemailclient-config.php');

$pinpointEmailClient = new Aws\PinpointEmail\PinpointEmailClient($configurations['settings']);
?>

<?php
$accountResult = $pinpointEmailClient->getAccount([]);
echo('<pre>' . print_r($accountResult, true) . '</pre>');
?>
<br/>

<?php
# The "From" address. This address has to be verified in Amazon Pinpoint in the region you're using to send email.
$SENDER = $configurations['default']['sender'];

# The addresses on the "To" line. If your Amazon Pinpoint account is in the sandbox, these addresses also have to be verified.
$TOADDRESS = $configurations['default']['recipients'];

$TEMPLATEARN = $configurations['default']['templateArn'];

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

    $SENDER = $_POST['SENDER'];
    $TOADDRESS = $_POST['TOADDRESS'];

    $content = '';

    if ($selected_content == 'simple') {

        $content = array(
            'Simple' => [
                'FromAddress' => 'AppMov',
                'Body' => [ // REQUIRED
                    'Html' => [
                        'Charset' => 'utf8',
                        'Data' => 'click <a href="https://doit.com/">here</a>', // REQUIRED
                    ]
                ],
                'Subject' => [ // REQUIRED
                    'Charset' => 'utf8',
                    'Data' => 'from PinpointEmailClient', // REQUIRED
                ],
            ]);
        
    } else if ($selected_content == 'template') {
        
        $content = array(
            'Template' => [
                'TemplateArn' => $TEMPLATEARN,
                'TemplateData' => json_encode (new stdClass)
            ]
        );        
    };

    try {
        $result = $pinpointEmailClient->sendEmail([
            'Content' => 
                $content,
            'Destination' => [
                'ToAddresses' => [$TOADDRESS],
            ],
            'FromEmailAddress' => $SENDER
        ]);    
        echo('<pre>' . print_r($result, true) . '</pre>');
    
    } catch (AwsException $e){
        error_log($e->getMessage());
    }
}     
?>

