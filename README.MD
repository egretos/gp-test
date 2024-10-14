# Game Point Test Assessment

## Requirements
- PHP 8.3
- Composer
- Docker

## Getting Started

### 1. Clone the Repository
```bash
git clone git@github.com:egretos/gp-test.git
cd gp-test
```

### 2. Set Up Environment
Create a `.env` file in the root of your project and configure your environment variables.
Don't forget to put your **free** key from https://app.exchangerate-api.com/ into the .env file
```bash
cp .env.example .env
```

### 3. Start Docker
Run the following command to start the services defined in `docker-compose.yml`:
```bash
docker-compose up
```

### 4. Access the PHP Container
Once the services are up, access the PHP container:
```bash
docker-compose exec php-fpm bash
```

### 5. Install Composer Dependencies
```bash
composer install
```

### 6. Run Migrations
Run the migrations to set up your database:
```bash
php console.php app:migrate
```

### 7. Import CSV Data
Internal data file contains 100000 different records

Import Internal CSV data into the database:
```bash
php console.php import:csv ./data/extended_payments.csv
```

### 8. Import Currency Rates
Import currency rates using your preferred source:
```bash
php console.php import:currency-rates
```

## Usage
- Locate http://localhost/ in your browser
- Enjoy!