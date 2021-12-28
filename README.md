# Project setup

```bash
git clone git@github.com:richercs/personal-data-demo-api.git
cd personal-data-demo-api
```

## Start developer environment

```bash
make dev
```
The API is available at:

http://127.0.0.1:8000/ping

JSON API endpoints:
```
get data for single user:           GET     /user/{id}                         
get data for all users:             GET     /user                              
post data to create new user:       POST    /user                              
put data to update existing user:   PUT     /user/{id}                         
patch partial data to update user:  PATCH   /user/{id}                         
delete user data:                   DELETE  /user/{id}
```

Example requests:
```
POST    /user
{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "dateOfBirth": "1992-01-01",
    "phoneNumbers": [
        {
            "phoneNumber": "+36700001231"
        },
        {
            "phoneNumber": "+36700001232"
        }
    ]
}
```
```
PUT    /user/{id}
{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "dateOfBirth": "1992-01-01",
    "phoneNumbers": [
        {
            "phoneNumber": "+36305555551"
        },
        {
            "phoneNumber": "+36700001232"
        }
    ]
}
```
```
PATCH   /user/{id}
{
    "name": "Jane Doe",
    "email": "jane.doe@example.com"
    "phoneNumbers": [
        {
            "phoneNumber": "+36305555551"
        }
    ]
}
```
## Run unit tests

```bash
make unit-test
```

## Stop all containers

```bash
make down
```

## Todos:
```
-- Currently the docker containers only work on linux if user has id: 1000
-- Use REST API bundles like: FOSRestBundle or API Platform for better error handling and less code duplication
-- Unit test coverage (currently only have one test)
```
