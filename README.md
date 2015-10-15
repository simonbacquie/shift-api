# shift-api

REST API written in the Spark framework for PHP. Uses Eloquent, the ORM from Laravel and Lumen, for data mapping.

Your user can be either an `employee`, or a `manager`.

## Auth

Use HTTP basic auth to authenticate every request, with the username as the User's `email`. PAsswords are saved as sha1 hashes, so here are some test credentials:

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

- In a Domain, why does $input not get populated as an array if the input is a JSON string? If the request's Content-type is JSON, it should parse it for you and make it available to you under $input.
- Why does AbstractFormatter only want me to send a few possible HTTP status codes (200, 400, 500, 520)? I would have wanted to return a 201 on a create and 204 on an update, for example. I should be able to send whatever integer HTTP status code I want when creating a Payload, and have it reach the response intact.
