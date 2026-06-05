FROM php:8.2-apache

# 1. Instalar dependencias del sistema y extensiones de PHP requeridas por Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 2. Habilitar Mod_Rewrite de Apache (Esencial para las rutas de Laravel)
RUN a2enmod rewrite

# 3. Configurar la carpeta pública del servidor web
# NOTA: En tu captura veo que tienes una carpeta "public" y otra "public_html". 
# Apuntaremos a "public" que es el estándar de Laravel. Si usas la otra, cambia el final por /public_html
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Copiar los archivos del proyecto al contenedor
COPY . /var/www/html

# 5. Instalar Composer y las dependencias de PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 6. Asignar permisos correctos a las carpetas de almacenamiento de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80