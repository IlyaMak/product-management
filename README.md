# Scandiweb task management

Live Demo: https://scandiweb-test-maklore.koyeb.app/

## Installation without docker

### Prerequisites:

- PHP v7.4
- MySql v5.7
- Composer v2.6.6
- Node.js v20.11.0
- Npm v10.2.4

### Steps:

1. `git clone`
2. `cp .env.example .env`
3. Update database variables in the .env file
4. `sh build/build.sh`
5. `php migrations/Version20240116135800.php`
6. `php -S localhost:84`
7. open http://localhost:84

## Installation with docker compose

### Prerequisites:

Docker Compose v2.21.0

### Steps:

1. `git clone`
2. `cp .env.example .env`
3. `sh build/build-docker.sh`
4. `docker compose exec php php migrations/Version20240116135800.php`
5. open http://localhost:84

## Content of the php production service

`php: image: user/scandiweb-test-task:1.0.0
ports: - '84:80' env_file: - .env`

## Build and push production docker container

1. `docker build -t user/scandiweb-test-task:1.0.0 -f Dockerfile .`
2. `docker push user/scandiweb-test-task:1.0.0`
