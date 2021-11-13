# Olx.ba search scheduler

Missing scheduler for Olx.ba searches. Production-ready small web application which notifies
you by email when something new is published within your saved search.

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Usage
Go to OLX.ba and set up your wanted search with all corresponding filters activated (usually you will 
save the search in their app as well). Then simply copy search url and save it in this app.

![Screenshot](https://i.ibb.co/wS7CFMK/ss.png)

After that, scheduler is set up to run every 10 minutes and it will do search and compare previous results, 
and notify you only about new results. Will not spam constantly.

## Installation

Clone project
```
git clone https://github.com/fajicbenjamin/olxba-search-scheduler.git
```
Install dependencies via Composer
```
composer install
```
Install and build assets (use appropriate build for dev or prod)
```
npm install
npm run dev
```
Migrate tables
```
php artisan migrate
```

Finally, you will want to start scheduler and queue listener
```
php artisan queue:work
php artisan schedule:run >> /dev/null 2>&1
```
