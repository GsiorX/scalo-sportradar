# Scalo - sportradar

## Build docker image
`docker build -t scalo-sportradar .`

## Run docker image
`docker run -t -d -p 80:8080 -d -v $(pwd):/var/www/html scalo-sportradar`

## Run commands inside the container
`docker exec -it <container_id> bash`