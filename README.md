# API (PHP)
## Get Started
After cloning the project, you need to do the following.
#### - Install Composer
```
composer install
```

#### - Copy and rename .env.example file to .env
#### - Define environment variables

## How does it work?
The first you need to get an access token, for this you need to make a GET request to
```
<Base_Url>/api/v1/access
```
answer example:
```
{
  "Access-Token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZWFkIjp0cnVlLCJ3cml0ZSI6ZmFsc2UsImV4cCI6MTYxOTYxNDQ1M30.9SajCrE3ANto_f8lJixeUaaWiXij59gs6xFKtRo4OoQ"
}
```
The token expires after 1 hour, then you must repeat this action for further use of the API.
Every request you want to execute from now on must include your token. If you want to access an endpoint `/api/v1/cards/sort` that is protected, you need to pass your token in the headers.
##### To send a POST request to `/api/v1/cards/sort` endpoint, you must send an unordered list of the following type
```
[
    "From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.",
    "Take the airport bus from Barcelona to Gerona Airport. No seat assignment.",
    "You have arrived at your final destination.",
    "From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B.",
    "Take train 78A from Madrid to Barcelona. Sit in seat 45B."
]
```
##### Your answer will be
```
[
    "Take train 78A from Madrid to Barcelona. Sit in seat 45B.",
    "Take the airport bus from Barcelona to Gerona Airport. No seat assignment.",
    "From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.",
    "From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B.",
    "You have arrived at your final destination."
]
```
## Testing


