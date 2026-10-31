# PHP + Apache (imagem oficial)
FROM php:8.2-apache

# O sistema usa PDO com MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Apache escuta na porta definida pelo Render (variável PORT; padrão do Render: 10000)
ENV PORT=10000
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Na nuvem o sistema fica na raiz do site (sem a pasta /epis nas URLs)
ENV APP_BASE_PATH=""

# Copia o sistema para a pasta pública do Apache
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 10000
