# PHP + Apache (imagem oficial)
FROM php:8.2-apache

# O sistema usa PDO com MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Apache escuta na porta definida pelo Render (variavel PORT; padrao do Render: 10000)
ENV PORT=10000
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Na nuvem o sistema fica na raiz do site (sem a pasta /epis nas URLs)
ENV APP_BASE_PATH=""

# Copia o sistema para a pasta publica do Apache
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 10000

# O Secret File do Render (/etc/secrets/ca.pem) fica ilegivel para o usuario do Apache.
# Ao iniciar, o container (root) copia o certificado para um local legivel
# e aponta DB_SSL_CA para a copia.
CMD ["sh", "-c", "if [ -r /etc/secrets/ca.pem ]; then cp /etc/secrets/ca.pem /etc/ssl/epis-ca.pem && chmod 644 /etc/ssl/epis-ca.pem && export DB_SSL_CA=/etc/ssl/epis-ca.pem; fi; exec apache2-foreground"]
