# Laravel 5.6 Project with Docker

This project uses **Laravel 5.6** along with **Docker containers**, integrating **Nginx**, **MySQL**, **PHP-FPM**. Follow the instructions below to set up the project, run it locally, and execute tests.

---

## **Prerequisites**

1. **Docker** and **Docker Compose** must be installed:
    - [Install Docker](https://docs.docker.com/get-docker/)
    - [Install Docker Compose](https://docs.docker.com/compose/install/)

2. **Composer** must be installed globally:
    - [Install Composer](https://getcomposer.org/download/)

---

## **Prerequisites**
Make sure you have the following installed:

- Docker and Docker Compose
- Composer 2.2 LTS
- Installation and Configuration

## **Installation and Configuration**

### 1. Clone the Repository

    ```bash
    git clone <git@github.com:jsmilenium/dacxi.git>
    cd dacxi
    ```

### 2. Create and Modify the .env File

    ```bash
    cp .env.example .env
    ```

Edit the .env file with the following configuration:

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=dacxi_mysql
    DB_PORT=33060
    DB_DATABASE=dacxi_cb
    DB_USERNAME=root
    DB_PASSWORD=123456
    ```

### 3. Start the Docker Containers
    
    ```bash
    docker-compose up -d
    ```

### 4. Install Dependencies
    ```bash
    docker exec -it dacxi_app composer install
    ```

### 5. Verify the Docker Containers are Running

    ```bash
    docker-compose ps
    ```

### 6. Generate the Application Key

    ```bash
    docker-compose exec app php artisan key:generate
    ```

### 7. Run Database Migrations
    
    ```bash
    docker-compose exec app php artisan migrate
    ```

### 8. Acces the Application
    
- The application will be available at [http://localhost:9000](http://localhost:9000)

### 9. Running Tests

    ```bash
    docker exec -it dacxi_app ./vendor/bin/phpunit
    ```

### 10. Common DockerCommands
    
- Acces a container:
    ```bash
    docker exec -it dacxi_app bash
    ``` 
  
- Stop all containers:
    ```bash
    docker-compose down
    ```
- Rebuild containers without cache:
    ```bash
    docker-compose up --build --force-recreate -d
    ```
- Check containers logs:
    ```bash
    docker-compose logs -f
    docker logs -f dacxi_app
    ```
- Run Artisan commands:
    ```bash
    docker exec -it laravel_app php artisan <command>
    ```

### 11. Troubleshooting
1. Database Connection Issues:
- Ensure the MySQl container is running
- Verify database connection details in the `.env` file

2. Permission Denied Issues:
- Ensure the `storage` and `bootstrap/cache` directories have the correct permissions:
    ```bash
    docker exec -it laravel_app chmod -R 777 storage bootstrap/cache
    ```
3. Port Conflict Issues:
- Ensure the ports specified in the `docker-compose.yml` file are not in use by other services on your machine.
- Check if the required ports (80 and 33060) are available
- Windows:
    ```bash
      netstat -ano | findstr :80
      netstat -ano | findstr :33060
    ```
- Linux:
    ```bash
      sudo lsof -i -P -n | grep LISTEN
    ```

### 12. Additional Notes
- Ensure you have the correct versions of PHP and Composer to avoid incompatibility issues.
- Use docker-compose restart <service> if any container becomes unresponsive.

### 13. Conclusion
This README.md provides a comprehensive guide to setting up and running your Laravel 5.6 application with Docker. If any issues arise, follow the troubleshooting section to resolve them quickly.You have successfully set up the Laravel 5.6 project with Docker containers. You can now access the application, run tests, and make changes to the codebase.
