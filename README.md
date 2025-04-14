# Symfony Base Repository

This repository contains the basic configuration to run Symfony applications with MySQL database

## Content
- PHP-APACHE container running version 8.2
- MySQL container running version 8.2.0

## Instructions
- `make build` to build the containers
- `make start` to start the containers
- `make stop` to stop the containers
- `make restart` to restart the containers
- `make prepare` to install dependencies with composer (once the project has been created)
- `make logs` to see application logs
- `make ssh` to SSH into the application container

## Create and Run the application
> [!TIP]
> Replace all the occurrences of `symfony-app` in the project with a more meaningful name. 
> You can use your IDE's find and replace option to complete this task.


1. Build and start the containers:
    ```shell
    make start
    ```
2. SSH into the container:
    ```shell
    make ssh
     ```
3. Create a Symfony project using the CLI:
    ```shell
    symfony new --no-git --dir project
    ```
4. Move all the content in the `project` folder to the root of the repository:
    ```shell
    mv project/{*,.*} . && rm -r project/
    ```
5. Add the content of `.gitignore` file to the root one, it should look like this:
    ```text
    .idea
    .vscode
    docker-compose.yml
    
    ###> symfony/framework-bundle ###
    /.env.local
    /.env.local.php
    /.env.*.local
    /config/secrets/prod/prod.decrypt.private.php
    /public/bundles/
    /var/
    /vendor/
    ###< symfony/framework-bundle ###
    ```
6. Once you have installed you Symfony application go to http://localhost:1000




To speak About:
- health check.
- Layers (Domain, application and Infrastructure)
- Value Object (UUID infrastructure inside Domain and explication)
- TDD
- Repository Patterns



- Testing
- Mothers
- About, save unfinished order into a database or what, I discovered a use case to uso that information to send a help email to support the order and finish it. I am not sure if later I am going to delete data from database or maybe set an state (Depends on product decisions and metrics that we want to measure)
- Speak about keycloak as a service instead of Symfony authorization
- **** make that the database created in the make start/build

- Explain how we can add different entity Managers using doctrine.yaml, if we need to use different databases, etc
- Explain how I develop the proyect:
  - Contract with the costumer
  - Controllers
  - Use Case (Application)
  - Repository
  - Aggregated, domain value Objects
  - Infrastructure
   To avoid contamination (Persistence is an implementation detail)
- clone of DateTimeValueObject, to keep immutability
- Explain why I dont add more complexity to Roles and how can I make it with permissions, etc