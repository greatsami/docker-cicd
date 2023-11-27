# DOCKER & CI/CD Project for test

This repo contains two simple projects:
    
* Backend API built in Laravel 10
    - one route for login
    - api resource for posts
    - export post (using Queue)
    - Daily backup (using schedule + crontab)
    - using Redis for cache
    - using Pest for testing
    - using phpstan to analyse code
    - built ApiClients for Google Books for test only

* Frontend Built in VueJS (no pretty UI installed)
    - List posts
    - Create post
    - action to publish post