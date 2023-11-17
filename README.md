# AWS SDK PHP API for Amazon Pinpoint - Email Sender
This repository serves as a demonstration of using the AWS SDK for PHP to send emails through Amazon Pinpoint. The project includes examples of sending emails with a simple body or using a template ARN. The entire application can be run locally using Docker Compose.

## Prerequisites
Before running the project, make sure you have the following:

* AWS credentials: Place your AWS credentials in the aws_credentials folder. You can obtain these credentials from the AWS Console.
* Docker and Docker Compose: Install Docker and Docker Compose on your machine.

## Getting Started
1. Clone this repository:

```
git clone https://github.com/kangks/amazon-pinpoint-php.git
cd amazon-pinpoint-php
```

2. Add your AWS credentials:

Place your AWS credentials in the `aws_credentials`` folder.

3. Build and run the Docker containers:

```
docker-compose up -d
```

This command will start the PHP application and an Amazon Pinpoint simulator.


4. Access the application:

Open your browser and go to `http://localhost:80``. You should see a simple interface to send emails.


## Usage
The application provides a form to send emails. Choose the email sending method:

Simple Body: Enter the recipient email, sender email, select "Simple", click "Send Email" to send a basic email.
Template ARN: Enter the recipient email, sender email, select "Template", click "Send Email" to send an email using a template.


## Configuration
You can modify the configuration in the `config/config.php` file. Update the Amazon Pinpoint settings, such as the region, as needed.

```
<?php

return (array(
        'profile' => 'pinpoint', // your AWS profile
        'region'  => 'us-east-1',
        'version'  => '2018-07-26',
    ));    

?>
```

## Contributing
Feel free to contribute to this project by submitting issues or pull requests.

## License
This project is licensed under the MIT License - see the LICENSE file for details.






