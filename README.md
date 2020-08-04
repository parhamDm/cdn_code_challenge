<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Deploy
in order to deploy laravel application you must have composer and php>=7.2 installed on your computer.
then configure mysql database and redis database in .env located in root of the 
application; then run these following commands:

```
composer install
php artisan migrate
```
this commands install required packages and the create database tables. then you can use following command to deploy 
laravel using php built-in webserver
```
php artisan serve
```
Finally, in order to enable sms listener queue, use following command
```
php artisan queue:listen
```
## how to use
### code operations
to create a new code use following request:
```
POST /api/codes

{
    "request_limit" : "100"
}
```
response contains following fields
- status_code: status code of processing request. 0 status for Success, -4 is invalid input.
- status_msg: message for status code.
- data: if request is SUCCESS, model created sill be returned. else error messages.

to see list of codes you must use following request:
```$xslt
GET /api/codes?limit=10
```
variable "limit" is optional to specify page size, this variable is 100 by default in .env file(MAX_PAGE_SIZE). response contains following fields
- status_code and status_msg: same as above
- data: list of codes
- links: links for next page and prev page
- meta: details of pagination. like page size, etc

sample response:
```json
{
  "data": [
    {
      "id": 4,
      "value": "61a5b1",
      "created_at": "2020-08-04 19:56:14",
      "request_limit": 123,
      "request_number": 0
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/codes?page=1",
    "last": "http://localhost:8000/api/codes?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://localhost:8000/api/codes",
    "per_page": "1000",
    "to": 1,
    "total": 1
  },
  "status_code": "0",
  "status_msg": "SUCCESS"
}
```
in order to see list of winners, use following request
```
GET /api/codes/{id}/winners?limit=10&verbose=true
```
verbose is an optional variable. if set, you can see exact date of request. response is same as getting list of codes.
### report
use following request to determine one has won or not:
```
GET /api/report/is_winner?number=09195250425&code=61a5b1
```
response contains following fields:
- status_code: 0 is winner and 1 is not winner. -2 for code not found
- status_msg: message for status code.
