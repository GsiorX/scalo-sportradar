# Scalo - sportradar

## Build docker image
`docker build -t scalo-sportradar .`

## Run docker image
`docker run -t -d -p 80:8080 -d -v $(pwd):/var/www/html scalo-sportradar`

## Run commands inside the container
`docker exec -it <container_id> bash`

## Install required dependencies
`docker exec <container_id> composer install`

## Run unit tests
`docker exec <container_id> composer tests:unit`

## Run phpstan
`docker exec <container_id> composer phpstan`

## Run phpcs
`docker exec <container_id> composer phpcs`

## Run mutation tests
`docker exec <container_id> composer mutation`

## Assumptions
- Team name cannot be empty
- Team name cannot be a whitespace character
- Team name must be unique across a game
- Team names must be unique across games on the scoreboard
- Score cannot be negative

- The team on the left is the home team in the summary list
