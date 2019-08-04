# Laravel 5.8 with Custom Authentication (username, email, or phone number)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.


## Features

- User Register
- User login with username, email, or phone number
- Password reset (send password reset code with email or SMS)
- Email verification (required [Mail driver](https://laravel.com/docs/5.8/mail) config)
- Phone verification (required [Nexmo SMS](https://laravel.com/docs/5.8/notifications#sms-notifications) config)
- Extra feature (optional):
	- phone validation when register new account to make sure input phone number is valid/exist. This feature need to use API from [Numerify](https://numverify.com) product of [APILayer](https://apilayer.com).
	- email validation when register new account to make sure input email is valid/exist. This feature need to use API from [Mailboxlayer](https://mailboxlayer.com) product of [APILayer](https://apilayer.com).

## Usage

- Clone the project and install required packages using command `composer install`
- Copy `.env.example` to `.env`, then setup your database configuration at `.env` file
- Update [Mail driver](https://laravel.com/docs/5.8/mail), [Nexmo SMS](https://laravel.com/docs/5.8/notifications#sms-notifications) for sending Email and SMS
- See `config/support.php` file for more detail information to config [Phone](https://numverify.com) and [Email](https://mailboxlayer.com) validation.
- Run command `php artisan key:generate` to generate new APP_KEY
- Run command `php artisan migrate` to generate database tables
- Run command `php artisan route:list` to see available routes

## Example configuration in `.env` file for Email and SMS

```json

		MAIL_DRIVER=mailgun
		MAILGUN_DOMAIN=mg.example.com
		MAILGUN_SECRET=xxxxxxxxxxxxxx
		MAIL_HOST=smtp.mailgun.org
		MAIL_PORT=25
		MAIL_USERNAME=xxxxxxxxxxxxx
		MAIL_PASSWORD=xxxxxxxxxxxxx
		MAIL_ENCRYPTION=tls
		MAIL_FROM_ADDRESS=noreply@example.com
		MAIL_FROM_NAME=Example

		NEXMO_SMS_ENABLED=true
		NEXMO_KEY=xxxxxxxxxx
		NEXMO_SECRET=xxxxxxxxxxxxxxxx
		NEXMO_SENDER=Example

		COUNTRY_API=xxxxxxxxxxxxxxx

		DEFAULT_PHONE_PREFIX=855
		PHONE_VALIDATE_ENABLED=true
		PHONE_VALIDATE_API=xxxxxxxxxxxxxxxxx

		EMAIL_VALIDATE_ENABLED=true
		EMAIL_VALIDATE_API=xxxxxxxxxxxxxxxxx
		EMAIL_VALIDATE_STRICT=xxxxxxxxxxxxxxxxxxx

```

## Credits

The fancy front-end of this project is based on [Material Design](https://materializecss.com).

## License

The project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
