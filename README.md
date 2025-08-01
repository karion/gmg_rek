# Project Setup

## Installation Steps

1. Copy `.env.dist` to `.env` and set your own values.
2. Run:

   ```bash
   make build
   make up-d
   make p-db-create
   make p-db-migrate

3. Open the import endpoint in your browser:

http://localhost:4000/import

4. Run:

   ```bash
   make s-composer-install

## Start Using the App

Visit: http://localhost:8000


# To Be Added

 - API documentation
 - Split the import into multiple processes
 - Sorting in symfony and api
 - change id(int) to id(uuid)

# Data source
``` 
MALE_FIRSTNAME=https://api.dane.gov.pl/1.4/resources/63929,lista-imion-meskich-w-rejestrze-pesel-stan-na-22012025-imie-pierwsze/data
FEMALE_FIRSTNAME=https://api.dane.gov.pl/1.4/resources/63924,lista-imion-zenskich-w-rejestrze-pesel-stan-na-22012025-imie-pierwsze/data
MALE_LASTNAME=https://api.dane.gov.pl/1.4/resources/63892,nazwiska-meskie-stan-na-2025-01-22/data
FEMALE_LASTNAME=https://api.dane.gov.pl/1.4/resources/63888,nazwiska-zenskie-stan-na-2025-01-22/data

