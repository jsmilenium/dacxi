# Laravel 5.6 Project with Docker

This project uses **Laravel 5.6** along with **Docker containers**, integrating **Nginx**, **Postgres**, **PHP-FPM**. Follow the instructions below to set up the project, run it locally, and execute tests.

---

## 1. **Architecture Overview**
- Laravel 5.6: Backend framework for handling business logic and API routes.
- PHP 7.4: Programming language used to write the application code.
- Docker and Docker Compose: Used to create isolated containers for different services:
- Nginx: Web server to handle incoming HTTP requests.
- Postgres: Database service to store persistent data.
- PHP-FPM: FastCGI Process Manager to handle PHP execution.
- Cache: Caching layer used to store daily coin prices and prevent redundant API calls.
- GuzzleHTTP: HTTP client used to interact with external APIs (CoinGecko).
- PHPUnit & Mockery: Testing libraries for unit and functional tests.

---

## 2. **Key Architecture Decisions**
### 1. **Caching:**

- We use a caching mechanism to avoid making redundant requests to the CoinGecko API for the same day. This ensures faster responses and reduces load on the external API.
 
### 2. **Service Layer Pattern:**
- We implemented service classes to encapsulate business logic and keep controllers lightweight. This improves readability and makes the code easier to maintain and test.
 
### 3. **GuzzleHTTP for External API Calls:**
 
- Guzzle is used to communicate with the CoinGecko API to retrieve coin prices. Proper error handling and retry mechanisms are in place to manage network failures.

### 4. **Testing Strategy:**
- We use PHPUnit and Mockery to create unit and functional tests. External services are mocked to ensure tests are fast and reliable without depending on network conditions.

---

## **Prerequisites**

### 1. **Docker and Docker Compose must be installed:**
- [Install Docker](https://docs.docker.com/get-docker/)
 - [Install Docker Compose](https://docs.docker.com/compose/install/)

### 2. **Composer must be installed globally:**
    - [Install Composer](https://getcomposer.org/download/)

---
## 3. **External Libraries Used**
- GuzzleHTTP: To handle HTTP requests to external APIs.
- Cache: For caching daily coin prices.
- PHPUnit: For unit and feature testing.
- Mockery: To mock dependencies and services in tests.
---

## 4. **Prerequisites**
Make sure you have the following installed:

- Docker and Docker Compose
- Composer 2.2 LTS
- Installation and Configuration
----
## 5. **Installation and Configuration**

### 1. **Clone the Repository**

   ```bash
    git clone <git@github.com:jsmilenium/dacxi.git>
    cd dacxi
   ```

### 2. **Create and Modify the .env File**

   ```bash
    cp .env.example .env
   ```

Edit the .env file with the following configuration:

  ```bash
    DB_CONNECTION=pgsql
    DB_HOST=dacxi-postgres
    DB_PORT=5432
    DB_DATABASE=dacxi_cb
    DB_USERNAME=postgres
    DB_PASSWORD=postgres
    COINGECKO_API_URL=https://api.coingecko.com/api/v3
    COINGECKO_API_KEY=your_api_key_here
  ```
---
## 6. *Running the Application*

### 1. **Start the Docker Containers**
    
  ```bash
    docker-compose up -d
  ```

### 2. Install Dependencies
  ```bash
    docker exec -it dacxi-app composer install
  ```

### 3. Generate the Application Key

   ```bash
    docker-compose exec app php artisan key:generate
   ```

### 4. Run Database Migrations and Seeders
    
   ```bash
    docker-compose exec app php artisan migrate --seed
   ```
---
## 7. **API Usage**

### 1. **Available Endpoints**
- GET /api/vi/coin/{symbol} 
- Example: [http://localhost:9000/api/v1/coin/BTC](http://localhost:9000/api/v1/coin/BTC)

### 8. Run the following command to get coin prices with cURL 
    
  ```bash
   curl --location 'localhost:9000/api/v1/coin/BTC' \
   --header 'Accept: application/json'
  ```
---
## 8. **Running Tests**

### 1. Running All Tests
   ```bash
        docker exec -it dacxi-app ./vendor/bin/phpunit
   ```

### 2. Common Docker Commands
- **Acces a container:**
    ```bash
    docker exec -it dacxi-app bash
    ``` 
  
- **Stop all containers:**
    ```bash
    docker-compose down
    ```
- **Rebuild containers without cache:**
    ```bash
    docker-compose up --build --force-recreate -d
    ```
- **Check containers logs:**
    ```bash
    docker-compose logs -f
    docker logs -f dacxi-app
    ```
- **Run Artisan commands:**
    ```bash
    docker exec -it dacxi-app php artisan <command>
    ```

### 3. Troubleshooting
1. **Database Connection Issues:**
- Ensure the Postgres container is running
- Verify database connection details in the `.env` file

2. **Permission Issues:**
- Ensure the `storage` and `bootstrap/cache` directories have the correct permissions:
    ```bash
    docker exec -it dacxi-app chmod -R 777 storage bootstrap/cache
    ```
3. **Port Conflicts:**
- Ensure the ports specified in the `docker-compose.yml` file are not in use by other services on your machine.
- Check if the required ports (9000 and 5432) are available
- Windows:
    ```bash
      netstat -ano | findstr :9000
      netstat -ano | findstr :5432
    ```
- Linux:
    ```bash
      sudo lsof -i -P -n | grep LISTEN
    ```
---

## 9. **Additional Notes**
- Retry Mechanism: The CoinGeckoService implements a retry mechanism to handle transient errors from the external API.
- Caching Strategy: Coin prices are cached for a day to reduce redundant API calls.
- Error Handling: We use custom exceptions like CoinGeckoApiException to handle external API errors gracefully.

## 10. **Conclusion**
- This project demonstrates how to build a scalable API using Laravel 5.6 with Docker. The architecture emphasizes separation of concerns through service layers and caching strategies. External dependencies are mocked in tests to ensure reliable and fast test execution.

- Feel free to explore the project, run tests, and extend the codebase. If any issues arise, refer to the Troubleshooting section or open an issue in the repository.
