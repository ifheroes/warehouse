#!/bin/bash

# Setze den Apache-Port zur Laufzeit basierend auf der Umgebungsvariable APACHE_PORT
if [ -z "$APACHE_PORT" ]; then
  APACHE_PORT=80
fi

# Konfiguriere Apache auf den angegebenen Port zu hören
sed -i "s/Listen 80/Listen $APACHE_PORT/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:$APACHE_PORT>/" /etc/apache2/sites-available/000-default.conf

# Starte Apache im Vordergrund
apache2ctl -D FOREGROUND
