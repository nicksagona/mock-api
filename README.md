# Mock API Data

This repository provides a quick and easy API with mock user data
to write and test other API-driven applications against.

### Installation

Fetch the repository and run:

```
composer install
```

Copy the original application config to the required live one:

```
cp app/config/app.http.orig.php app/config/app.http.php
``` 

Config your database by running:

*(Please note that the mock data is currently for MySQL-only)*

```
./kettle db:config
```

Then to install the mock data in your database, run:

```
./kettle db:seed
```

Run the PHP server to access the mock API:

```
./kettle serve
```

You can now access the mock API:

```
curl -i -X GET http://localhost:8000/users
```

### Using Authentication

If you would like to test against the mock API using a simple
authentication header, you can turn it one by setting the `auth`
value to `true` and setting the `auth_key` value in the
application config file. Then you can access the mock API with
an authorization header like this:

```
curl -i -X GET --header "Authorization: Bearer my-auth-key" http://localhost:8000/users
```

A bad or missing auth header will result in a 401 error response.
