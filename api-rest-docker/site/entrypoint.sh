#!/bin/bash

echo "Esperando a MySQL para estar disponible en $DB_HOST..."

# Intentar conectarse a MySQL hasta que esté disponible
until mysql -h"$DB_HOST" -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" -e "SHOW DATABASES;" &> /dev/null
do
  echo "Esperando a MySQL..."
  sleep 5
done

# Verificar si la tabla 'people' ya existe
TABLE_EXISTS=$(mysql -h"$DB_HOST" -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" -e "SHOW TABLES LIKE 'people';" | grep 'people')

if [ -z "$TABLE_EXISTS" ]; then
  echo "Tabla 'people' no encontrada. Importando init.sql a la base de datos $MYSQL_DATABASE..."
  mysql -h"$DB_HOST" -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < /docker-entrypoint-initdb.d/init.sql
else
  echo "La tabla 'people' ya existe. Saltando la importación."
fi

# Iniciar Apache
apache2-foreground