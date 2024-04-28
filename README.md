### Installation

> make sure that docker & docker-compose installed

Run `make build`.

On local machine project accessible via `localhost:92`. 

Task 1 `http://localhost:92/form`

Task 2 can be used via `docker exec -it be-7days-task-php-fpm php bin/console app:generate-summary-post`

> phpstan used for making this project more type safe and fix non-obvious issues with conditions or code structure. 

> deptract also can be used in scope of DDD-like project architecture.
