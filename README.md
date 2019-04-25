# Mock API Data

This repository provides a quick and easy API with mock user data
to write and test other API-driven applications against.

### Installation & Setup

Fetch the repository and run:

```
composer install
```

Copy the original application config to the required live one:

```
cp app/config/app.http.orig.php app/config/app.http.php
``` 

Configure your database by running:

*(Please note that the mock data is currently for MySQL-only)*

```
./kettle db:config
```

Install the mock data in your database by running:

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

A bad or missing authorization header will result in a 401 error response.

### Examples

##### GET

You can filter the results of fetching users with the `GET` method
with query parameters. The following query parameters are supported:

 - `page`
 - `limit`
 - `sort`
 - `filter`
 - `fields`

```
curl -i -X GET \
    "http://localhost:8000/users?page=2&limit=20&sort=-last_name"
```

The `sort` parameter accepts the field name by which to sort the
result set, which will default to ascending order, unless the field
name is preceded with a `-` like the example above, which will set
the sort order to descending order.

The `fields` parameter can accept multiple field names to return
to select only the columns you which to select. The `filter`
parameter can accept multiple conditional strings:

```
curl -i -X GET \
    "http://localhost:8000/users?fields[]=id&fields[]=username\
&filter[]=username+LIKE+jo%"
```

##### POST

You can create a new user by using the `POST` method with the
following URL:

```
curl -i -X POST -d"username=testuser&first_name=Test" \
    "http://localhost:8000/users"
```

##### PUT

You can update an existing user by using the `PUT` method with
the following URL:

```
curl -i -X PUT -d"username=testuser2&first_name=Test2" \
    "http://localhost:8000/users/501"
```

##### DELETE

You can delete an existing user by using the `DELETE` method
with the following URL:

```
curl -i -X DELETE "http://localhost:8000/users/501"
```

Alternatively, you can delete multiple users at a time with
the `DELETE` method and passing an array of user ids:

```
curl -i -X DELETE -d"rm_users[]=501&rm_users[]=502" \
    "http://localhost:8000/users"
```
