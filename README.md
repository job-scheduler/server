job-scheduler-server
====================

## Database configuration

1. Create a database configuration file in /share/config/database/jobscheduler.conf
2. Creating database schema
    vendor/bin/doctrine orm:schema-tool:create

## Starting the server

    php -S 0.0.0.0:8080 -t web/

Now you can open http://localhost:8080 in your browser.

The JSON REST API can be viewed here: http://localhost:8080/api/v1
