# Simple Mailer
This application is a small demo tool making use of Vuejs, Tailwindcss, and Laravel 5.5 to power a simple interface to deliver
an email to a defined address using a core provider, and gracefully falling back to a secondary provider if the first one fails.

![](https://i.imgur.com/p2OLsNx.png)

# Installation
This quick installation tutorial will get this application running in a local development environment to give you a peek at
how it works, and how it looks.

### Dependencies
In development environments you'll need the following dependencies installed.

* PHP 7.1+ with the following extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML
* Nodejs 6+
* MySQL 5.7+ (with a table and user configured)
* [Composer](https://getcomposer.org/download/)
* Nginx (optional)

### Download
You'll want to clone this repository using the command below to a location of your choosing.
```
git clone https://github.com/DaneEveritt/SimpleMailer .
```

### Dependencies
Once you have the files downloaded we'll need to install all of the dependencies for the software.

```
composer install
npm install
```

### Environment Setup
Once we have dependencies installed we need to setup our environment file. This can be done by running `cp .env.example .env` and then
running `php artisan key:generate` which will create an application encryption key.

Now that we have the basic environment setup lets open that `.env` file and make a few updates.

`APP_TIMEZONE` — You should set this to the timezone that this app is running in.

`APP_URL` — Set this to the URL where this application is running so that emails originate from the correct address. Include `http://` at the front.

`DB_*` — You'll want to adjust these settings as necessary to ensure that the application can connect to your database instance using the table and user you setup earlier.

`MAIL_DRIVER` — This is where the magic happens with this app. You'll want to set this to one of the supported drivers: smtp, sendmail, mailgun, mandrill, ses, sparkpost, or log. By default this app will send email first using the SMTP credentials and falling back to logging the email to a log if that fails. Please reference the [Laravel Mail Documentation](https://laravel.com/docs/5.5/mail#driver-prerequisites) for more details about these drivers as they may require additional dependencies or environment variables. 

`MAIL_DRIVER_FALLBACK` — Same as the `MAIL_DRIVER`, except this is the fallback driver that should be used if the main driver reports an error.

`MAIL_DELIVER_TO` — The email address that messages should be sent to that are sent via this app.

### Running the Queue Worker
In order for emails to be processed a queue worker must be running. By default the driver is set to the database, however if you are wanting to avoid additional overhead you may set `QUEUE_DRIVER=sync` and emails will be sent right away with a slight delay on the app. If you use the sync driver this step is unnecessary.

You'll want to set this up as a long running task which [the Laravel documentation covers](https://laravel.com/docs/5.5/queues#supervisor-configuration), but for the sake of development we will run this in the foreground in a seperate SSH window.
```
php artisan queue:work --tries=1
```

### Compiling Assets
In the development builds we need to compile our assets so the application looks pretty. To do so, simply run the command below:
```
npm run build
```

This will compile the CSS and JS for the web.

### Running Local Webserver
If you're using Nginx you'll need to configure it to point to this application, but for quick and dirty development environment testing, simply run `php artisan serve` and browse to the URL it provides.

Thats it! You now have a simple message sending platform running.
