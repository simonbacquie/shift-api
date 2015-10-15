# shift-api

REST API written in the Spark framework for PHP. Uses Eloquent, the ORM from Laravel and Lumen, for data mapping.

Your user can be either an `employee`, or a `manager`.

## Auth

Use HTTP basic auth to authenticate every request, with the username as the User's `email`. Passwords are saved as sha1 hashes, so here are some test credentials:

## Sample Credentials

### Users

|name|email|password|
|----|-----|--------|
|Peter|peter@innitech.com|superman3|
|Joanna|joanna@schlotzskys.net|piecesofflair|
|Michael|mbolton@intertrode.com|tpsreports|


### Managers

|name|email|password|
|----|-----|--------|
|Lumbergh|lumbergh@innitech.com|yeahhh|
|Bob|bob@consultants.net|whatdoyoudohere|

Every endpoint is authorized by role.

## Comments

This was my first time using the Spark framework. I liked it overall, but I was a bit puzzled by a couple things:

- In a Domain, why does $input not get populated as an array if the input is a JSON string? If the request's Content-type is JSON, it should parse it for you and make it available to you under $input. This is why I ended up using x-www-form-urlencoded when creating/updating records.
- Why does AbstractFormatter only want me to send a few possible HTTP status codes (200, 400, 500, 520)? I would have wanted to return a 201 on a create and 204 on an update, for example. I should be able to send whatever integer HTTP status code I want when creating a Payload, and have it reach the response intact. https://github.com/sparkphp/spark/blob/b2a9b32f461ab39f83089b9eade46f8a37e70156/src/Formatter/AbstractFormatter.php#L43-L59
- I attempted to hack around these issues without modifying the original framework source in the `vendor` folder, but wasn't successful. This can be seen under `hacks.php`

## curl examples

As an employee, see all my shifts:
```
curl -X GET -H "Authorization: Basic cGV0ZXJAaW5uaXRlY2guY29tOnN1cGVybWFuMw==" 'http://spark-project.app/me/shifts'
```

As an employee, see who works with you during one of your shifts:
```
curl -X GET -H "Authorization: Basic cGV0ZXJAaW5uaXRlY2guY29tOnN1cGVybWFuMw==" 'http://spark-project.app/me/shifts/1'
```

As a manager, create a shift:
```
curl -X POST -H "Authorization: Basic bHVtYmVyZ2hAaW5uaXRlY2guY29tOnllYWhoaA==" -H "Content-Type: application/x-www-form-urlencoded" -d 'manager_id=2&employee_id=1&start_time=2015-02-03+00%3A00%3A00&end_time=2015-02-03+08%3A00%3A00' 'http://spark-project.app/shifts'
```

As a manager, update a shift (can be any field including employee ID or times):
```
curl -X PUT -H "Authorization: Basic bHVtYmVyZ2hAaW5uaXRlY2guY29tOnllYWhoaA==" Content-Type: application/x-www-form-urlencoded" -d 'end_time=2015-02-03+20%3A16%3A00&id=17' 'http://spark-project.app/shifts'
```

As an employee, see how many hours you worked for each work week:
```
curl -X GET -H "Authorization: Basic cGV0ZXJAaW5uaXRlY2guY29tOnN1cGVybWFuMw==" 'http://spark-project.app/me/workweeks/2015-02-01'
```

As a manager, see all the shifts that fall in a date range:
```
curl -X GET -H "Authorization: Basic bHVtYmVyZ2hAaW5uaXRlY2guY29tOnllYWhoaA==" 'http://spark-project.app/shifts?start_time=2015-10-01&end_time=2015-10-30'
```

As a manager, see an employee (including their contact info):
```
curl -X GET -H "Authorization: Basic bHVtYmVyZ2hAaW5uaXRlY2guY29tOnllYWhoaA==" 'http://spark-project.app/employees/1'
```
