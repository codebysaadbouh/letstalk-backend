# API Let's Talk
This repository contains the API for the Let's Talk application.
The application is maintained in a Docker-based development environment for ease of use
____
> ### `version: 1.0` 
> 
> **Stacks :** `Symfony` - `API Platform` - `Postgresql` - `Docker`

## Run server

- Open repertory of project on terminal and run command (install docker services) : 
  ```
  docker-compose up -d
  ```
  
- Open letstalk-api repertory on terminal and run command (install dependencies): 
  ```
  composer install
  ```
  
-  Connect application with server : 
    - Create .env.local file on letstalk-api repertory and paste this code :
        
        ```yaml
        ###> doctrine/doctrine-bundle ###
        DATABASE_URL="postgresql://administrator:admin123@127.0.0.1:5432/letstalk-database?charset=utf8"
        ###< doctrine/doctrine-bundle ###
        ###> symfony/mailer ###
        MAILER_DSN=smtp://maildev_docker_symfony:25
        ###< symfony/mailer ###
        ```
 - Create database and migrate tables (Require [symfony cli](https://symfony.com/downloads))
    
    - Create database
    
         ```
         symfony console doctrine:database:create
         ```
     - Migrate database
    
         ```
         symfony console doctrine:migrations:migrate
         ```
  - Load the fixtures :

    ```
    symfony console doctrine:fixtures:load
    ```
   
   
   
   
