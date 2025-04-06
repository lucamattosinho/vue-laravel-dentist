# Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instala extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Instala unzip, git e outras dependências
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    zip \
    libzip-dev

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do Laravel
COPY . .

# Configura o Apache para apontar para a pasta 'public'
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Dá permissão à storage e bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Habilita o mod_rewrite (necessário pro .htaccess funcionar)
RUN a2enmod rewrite

# Reinicia apache com foreground
CMD ["apache2-foreground"]
