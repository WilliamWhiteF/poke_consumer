#!/bin/sh

echo "Waiting for mariadb..."
while ! nc -z $DB_HOST 3306; do
    sleep 0.1
done

echo "Mariadb started"

echo "Waiting for queue..."
while ! nc -z $RABBITMQ_HOST 5672; do
    sleep 0.1
done

echo "Queue started"

# Apply database migrations
if [ $service == "app" ]; then
    echo "Apply database migrations"
    php artisan migrate
fi

exec "$@"
