# Restfull API Lumen 5.5 with JWT Authentication, Dingo API and CORS Support

Basically this is a starter kit for you to integrate Lumen with [JWT Authentication](https://jwt.io/).
If you want to Lumen + Dingo + JWT for your current application, please check [here](https://github.com/ayrokid/lumen-jwt-dingo).

## What's Added

- [Lumen 5.5](https://github.com/laravel/lumen/tree/v5.5.0).
- [JWT Auth](https://github.com/tymondesigns/jwt-auth) for Lumen Application. <sup>[1]</sup>
- [Dingo](https://github.com/dingo/api) to easily and quickly build your own API. <sup>[1]</sup>
- [Lumen Generator](https://github.com/flipboxstudio/lumen-generator) to make development even easier and faster.
- [CORS and Preflight Request](https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS) support.


## Quick Start

- Clone this repo or download it's release archive and extract it somewhere
- You may delete `.git` folder if you get this code via `git clone`
- Run `composer install`
- Run `php artisan jwt:generate`
- Configure your `.env` file for authenticating via database
- Set the `API_PREFIX` parameter in your .env file (usually `api`).

## A Live PoC

- Run a PHP built in server from your root project:

```sh
php -S localhost:8000 -t public/
```

Or via artisan command:

```sh
php artisan serve
```

To authenticate a user, make a `POST` request to `/api/login` with parameter as mentioned below:

```
Example : 
email: johndoe@example.com
password: johndoe
```

Request:

```sh
curl -X POST -F "email=johndoe@example.com" -F "password=johndoe" "http://localhost:8000/api/login"
```

Response:

```
{
  "success": {
    "access_token": "a_long_token_appears_here"
    "toke_type": "bearer",
    "expires_in": microtime
  }
}
```

- With token provided by above request, you can check authenticated user by sending a `GET` request to: `/api/me`.

Request:

```sh
curl -X GET -H "Authorization: Bearer a_long_token_appears_here" "http://localhost:8000/api/"
```

Response:

```
{
  "success": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "johndoe@example.com",
      "created_at": null,
      "updated_at": null
    }
  }
}
```

## License

```
Laravel and Lumen is a trademark of Taylor Otwell
Sean Tymon officially holds "Laravel JWT" license
```

## Donation

If this project help you reduce time to develop, you can give me a cup of coffee :) 

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=muh.yanun%40gmail%2ecom&lc=ID&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted)