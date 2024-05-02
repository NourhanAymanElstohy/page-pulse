#######
# Database Dockerfile
#

FROM mysql
LABEL version="1.0" \
    description="This is mysql container image" \
    creationDate="24-03-02" \
    author="Nourhan Ayman"

ENV MYSQL_ROOT_PASSWORD="PASSWORD"

EXPOSE 3306
ADD schema.sql /docker-entrypoint-initdb.d

