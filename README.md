# Laravel Error Notifier

**Laravel Error Notifier** is a Laravel package that sends email notifications whenever an error occurs in your Laravel application. It helps you monitor and address issues promptly.

## Installation

### Step 1: Install via Composer

You can install the package via Composer. Run the following command in your Laravel application's root directory:

```bash
composer require syntech/notifier

Step 2: Publish the Configuration File

Publish the package's configuration file to customize the email recipient for error notifications:

bash

php artisan vendor:publish --provider="SyntechNotifier\LaravelErrorNotifier\LaravelErrorNotifierServiceProvider"

This command will create a configuration file at config/error-notifier.php.
Step 3: Configure the Email Recipient

Open the newly created configuration file config/error-notifier.php and set the email address where error notifications should be sent:

php

return [
    'email' => env('ERROR_NOTIFIER_EMAIL', 'admin@example.com'),
];

Ensure you set the ERROR_NOTIFIER_EMAIL environment variable in your .env file:

env

ERROR_NOTIFIER_EMAIL=your-email@example.com

Step 4: Configure Mail Settings

Ensure your Laravel application's mail settings are correctly configured in the .env file. Here's an example configuration using SMTP:

env

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"

Replace these settings with your actual mail server details.
Step 5: Update Logging Configuration

Add the custom log channel to your application's config/logging.php file:

php

use SyntechNotifier\LaravelErrorNotifier\Logging\CustomHandler;

return [
    'channels' => [
        // other channels...

        'email' => [
            'driver' => 'custom',
            'via' => CustomHandler::class,
            'level' => 'error',
        ],
    ],
];

Step 6: Update Exception Handler

Open the app/Exceptions/Handler.php file and update the report method to log errors to the email channel:

php

use Illuminate\Support\Facades\Log;
use Throwable;

public function report(Throwable $exception)
{
    parent::report($exception);

    if ($this->shouldReport($exception)) {
        Log::channel('email')->error('An error occurred', ['exception' => $exception]);
    }
}

Usage

Once installed and configured, the package will automatically send an email notification whenever an error occurs in your Laravel application.
Customizing the Notification Email

If you need to customize the email notification, you can modify the ErrorOccurred notification class located at src/Notifications/ErrorOccurred.php. This class defines the content and structure of the email sent when an error occurs.
Example

Here is an example of what the email notification might look like:

yaml

Subject: Error Occurred in Your Application

An error has occurred:
- Message: Example error message
- File: /path/to/file.php
- Line: 123
- Stack Trace:
  #0 /path/to/file.php(123): exampleFunction()
  #1 {main}

Please address this issue promptly.

Contributing

If you would like to contribute to this package, please follow these steps:

    Fork the repository on GitHub.
    Create a new branch for your feature or bugfix.
    Make your changes and commit them with a descriptive message.
    Push your changes to your forked repository.
    Submit a pull request to the main repository.

License

This package is open-source software licensed under the MIT license.
Support

If you encounter any issues or have questions, please feel free to open an issue on the GitHub repository.
