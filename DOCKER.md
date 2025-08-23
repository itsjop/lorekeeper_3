# Running Lorekeeper with Docker

This guide will help you set up and run Lorekeeper using Docker and Docker Compose, making it easy to get started without manual installation steps.

## Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Quick Start

1. Clone the repository:
   ```
   git clone https://github.com/corowne/lorekeeper.git
   cd lorekeeper
   ```

2. Start the Docker containers:
   ```
   docker-compose up -d --build
   ```

   Note: The `--build` flag is important for the first run to ensure Docker builds the images locally instead of trying to pull them from a remote registry.

3. Wait for the setup to complete. The first time you run this, it will:
   - Set up the database
   - Install PHP dependencies
   - Generate application key
   - Run database migrations
   - Add basic site data
   - Compile frontend assets

4. Access the application:
   - Open your browser and go to `http://localhost:8080`

## Setting Up Social Media Authentication

For social media authentication to work, you need to update the `.env` file with your client ID and secret for at least one supported platform.

1. Stop the containers:
   ```
   docker-compose down
   ```

2. Edit the `.env` file in the project root and add your social media credentials.
   See [the Wiki](http://wiki.lorekeeper.me/index.php?title=Category:Social_Media_Authentication) for platform-specific instructions.

3. Restart the containers:
   ```
   docker-compose up -d
   ```

## Setting Up Admin Account

To set up the admin account:

1. Access the app container:
   ```
   docker-compose exec app bash
   ```

2. Run the admin setup command:
   ```
   php artisan setup-admin-user
   ```

3. Follow the prompts to create your admin account.

4. You will need to send yourself the verification email and then link your social media account as prompted.

## Customizing the Setup

### Database Configuration

The default database configuration is:
- Database: `lorekeeper`
- Username: `lorekeeper`
- Password: `secret`
- Root Password: `root`

If you want to change these values, edit the `docker-compose.yml` file before starting the containers.

### PHP Configuration

PHP configuration can be modified in the `php/local.ini` file.

### Nginx Configuration

Nginx configuration can be modified in the `nginx/conf.d/app.conf` file.

### MySQL Configuration

MySQL configuration can be modified in the `mysql/my.cnf` file.

## Troubleshooting

### Platform Compatibility Issues

If you encounter an error like `no matching manifest for linux/arm64/v8 in the manifest list entries`, it means Docker is trying to use an image that doesn't support your system's architecture (typically ARM64 for Apple Silicon Macs).

To resolve this:

1. Make sure you're using the latest version of the repository with ARM64 compatibility updates
2. Run with the explicit platform setting:
   ```
   TARGETPLATFORM=linux/arm64 docker-compose up -d --build
   ```
3. If the issue persists with a specific service, you can try forcing emulation for that service by setting its platform to linux/amd64 in docker-compose.yml

### Container Logs

To view logs for a specific container:
```
docker-compose logs app    # For PHP/Laravel logs
docker-compose logs webserver  # For Nginx logs
docker-compose logs db     # For MySQL logs
```

### Restarting Containers

If you need to restart the containers:
```
docker-compose restart
```

### Rebuilding Containers

If you make changes to the Dockerfile or need to rebuild the containers:
```
docker-compose up -d --build
```

This ensures that Docker rebuilds the images locally rather than trying to pull them from a remote registry.

### Running on ARM64 Systems (Apple Silicon Macs)

If you're using an ARM64-based system like an Apple Silicon Mac (M1, M2, etc.), you might encounter platform compatibility issues. The Docker setup has been configured to handle this automatically by:

1. Using MySQL 5.7 with platform set to linux/amd64 (runs via emulation)
2. Using platform-specific builds for the PHP and Nginx containers

To explicitly set the target platform for all services, you can use:

```
TARGETPLATFORM=linux/arm64 docker-compose up -d --build
```

For optimal performance on ARM64 systems, you can also try:

```
TARGETPLATFORM=linux/arm64 COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 docker-compose up -d --build
```

This enables BuildKit which can improve build performance.

### Port Conflicts

If you encounter an error like `Error response from daemon: Ports are not available: exposing port TCP 0.0.0.0:8080 -> 127.0.0.1:0: listen tcp 0.0.0.0:8080: bind: address already in use`, it means that port 8080 is already in use on your host machine.

To resolve this, you can either:

1. Stop the service that's using port 8080 on your host machine
2. Change the port mapping in `docker-compose.yml` to use a different port:
   ```
   ports:
     - "8081:80"  # Change 8080 to another port like 8081
     - "8443:443"
   ```
   Then update the access URL to match your new port (e.g., `http://localhost:8081`)

### MySQL Database Issues

If you encounter MySQL database issues, such as:

- `Failed to initialize DD Storage Engine`
- `No space left on device`
- `Cannot resize redo log file`
- `unknown variable 'innodb_redo_log_capacity'`
- Connection refused errors

These are typically caused by MySQL requiring more disk space than is available or configuration incompatibilities. To resolve these issues:

1. The Docker setup now uses MySQL 5.7 instead of 8.0, which has lower resource requirements
2. The MySQL configuration in `mysql/my.cnf` has been optimized for low resource usage:
   - Using smaller log file sizes
   - Reducing buffer pool size
   - Limiting connections
   - Using compatible configuration parameters for MySQL 5.7
3. The MySQL data directory is now stored in memory using tmpfs instead of on disk:
   ```yaml
   tmpfs:
     - /var/lib/mysql:rw,noexec,nosuid,size=500m
   ```
   This significantly reduces disk space requirements and improves performance, but note that data will not persist if the container is stopped.

4. If you still encounter issues, you can try:
   - Increasing the tmpfs size in `docker-compose.yml` if you need more space
   - Clearing the database volume: `docker-compose down -v` (warning: this will delete all your data)
   - Increasing the disk space available to Docker
   - Checking if your Docker environment has disk space limits

If MySQL starts but the application can't connect to it, check:
- MySQL logs: `docker-compose logs db`
- Application logs: `docker-compose logs app`
- Try restarting just the database: `docker-compose restart db`

### Using Docker Compose Bake for Better Performance

Docker Compose now supports delegating builds to Bake for better performance. To enable this feature:

```
COMPOSE_BAKE=true docker-compose up -d --build
```

If you encounter a permission error like `stat /Users/username/.docker/buildx/instances: permission denied`, you need to fix the permissions for your Docker Buildx directory:

1. Check the ownership of your Docker directory:
   ```
   ls -la ~/.docker
   ```

2. Fix the permissions:
   ```
   sudo chown -R $USER:$USER ~/.docker
   ```

3. If the buildx directory doesn't exist, you may need to create it:
   ```
   mkdir -p ~/.docker/buildx
   ```

4. Try running the command again:
   ```
   COMPOSE_BAKE=true docker-compose up -d --build
   ```

### Accessing the Database

To access the MySQL database directly:
```
docker-compose exec db mysql -u lorekeeper -p lorekeeper
```
When prompted, enter the password (`secret` by default).

## Data Persistence

All data is persisted in Docker volumes:
- Database data is stored in the `dbdata` volume
- Application files are mounted from your local directory

This means your data will persist even if you stop or remove the containers.
