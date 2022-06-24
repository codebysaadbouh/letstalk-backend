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
    - Create .env.local file on letstalk-api repertory
   
        ```
        touch .env.local
        ```
        
   - 
