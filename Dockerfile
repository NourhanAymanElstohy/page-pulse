FROM  docker.io/bitnami/laravel:latest as builder

WORKDIR /app
COPY . /app
ADD ./.env.example /app/.env
ADD ./entry.sh /entry.sh
RUN chmod +x /entry.sh

RUN composer require --no-interaction

RUN php artisan key:generate

RUN php artisan migrate

RUN php artisan db:seed

FROM builder as runner

USER 0

EXPOSE 8000

ENTRYPOINT ["/entry.sh"]
