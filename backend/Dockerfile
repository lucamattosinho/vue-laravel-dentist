# Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instala extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do Laravel
COPY . .

# Dá permissão à storage e bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Instala dependências do Laravel
RUN composer install

# Expõe a porta do Apache
EXPOSE 80

# Comando para rodar o Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
