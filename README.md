# TUS Server with Symfony 7 and Docker

This project is a TUS (Tus Upload Service) server implementation using **Symfony 7** and **Docker**. It enables resumable file uploads using the TUS protocol.

## Table of Contents

- [Requirements](#requirements)
- [Project Setup](#project-setup)
- [Docker Setup](#docker-setup)
- [Usage](#usage)
- [File Structure](#file-structure)
- [Code Style](#code-style)
- [License](#license)

## Requirements

- **Docker**: Ensure you have Docker and Docker Compose installed on your system.
- **Symfony 7**: The application runs on Symfony 7 and requires a working knowledge of this framework.

## Project Setup

### 1. Clone the Repository

```bash
git clone https://github.com/your-repo/tus-symfony-server.git
cd tus-symfony-server
```

### 2. Install PHP and Symfony dependencies

Make sure you have **Composer** installed. Run the following command inside the project directory:

```bash
composer install
```

### 3. Set up the Environment

Create a `.env.local` file to configure your environment variables, such as the MySQL credentials, and adjust the paths for file storage.

Example:

```bash
DATABASE_URL="mysql://symfony:symfony@mysql:3306/symfony"
```

## Docker Setup

The project comes with a Docker setup including Nginx, PHP-FPM, and MySQL services. The Docker configuration files are available in the `docker` directory.

### 1. Build and Start Containers

Run the following command to start your containers:

```bash
docker-compose up --build
```

This will:
- Build the PHP container for Symfony.
- Set up the Nginx web server.
- Create and configure a MySQL database.

### 2. Access the Application

Once Docker is running, you can access the Symfony application at:

```bash
http://localhost:8080
```

### 3. Upload Folder

Make sure to adjust the path for the upload folder in the `docker-compose.yml`:

Replace with your uploads folder path:

```bash
- ./var/uploads:your_folder_path
  ```

## Usage

### TUS Server Endpoint

The TUS server is accessible at the endpoint `/tus`. The server accepts the following HTTP methods:

- `POST`: Initialize new file uploads.
- `PATCH`: Continue an upload from a previously uploaded chunk.
- `HEAD`: Check the status of an upload.
- `OPTIONS`: Pre-flight requests to check server capabilities.

Example of a valid TUS endpoint:

```bash
http://localhost:8080/tus/{token}
```

### Error Handling and Logging

The `TusController` handles TUS protocol interactions, and errors are logged using the `LoggerInterface`.

In case of errors, the controller will return a JSON response:

```json
{
"error": "Erreur TUS",
"message": "Specific error message"
}
```

## File Structure

Key components of the project:

- **Controller**: `TusController.php`
    - Handles all TUS-related routes and interactions with the TUS service.

- **Service**: `TusService.php`
    - Initializes and configures the TUS server. Sets upload directory and cache store using Symfony parameters.

- **Docker Setup**:
    - **Dockerfile**: Defines the PHP-FPM image setup and application dependencies.
    - **docker-compose.yml**: Sets up the environment with PHP, Nginx, and MySQL services.

## Code Style

The project includes **PHP CS Fixer** for automatic code style enforcement. To apply consistent formatting to the codebase, run:

```bash
vendor/bin/php-cs-fixer fix
```

Code styles are automatically corrected according to predefined rules in the `.php_cs.dist` configuration file.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.
