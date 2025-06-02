# Use an official PHP image with Apache
FROM php:8.2-apache

# Install necessary PHP extensions
# pdo_sqlite for SQLite database access
# intl for IntlDateFormatter
RUN docker-php-ext-install pdo_sqlite intl
RUN apt-get update && apt-get install -y sqlite3 && rm -rf /var/lib/apt/lists/*

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the application files from the current directory in the host
# to the working directory in the container
COPY . /var/www/html/

# Apache runs as www-data user by default.
# Ensure www-data has write permissions to the directory containing the SQLite database
# and the database file itself if it exists.
# The SQLite database is at template/functions/db.sqlite
# We'll ensure the template/functions directory is writable by the group,
# and add www-data to the root group (or give ownership to www-data).
# A simpler approach for Apache images is often to chown the specific directory.
RUN chown -R www-data:www-data /var/www/html/template/functions && \
    chmod -R 775 /var/www/html/template/functions

# (Optional) If you want to ensure db.sqlite itself is writable if it gets copied:
# RUN if [ -f /var/www/html/template/functions/db.sqlite ]; then \
#     chown www-data:www-data /var/www/html/template/functions/db.sqlite && \
#     chmod 664 /var/www/html/template/functions/db.sqlite; \
#     fi

# Expose port 80 for the Apache web server
EXPOSE 80

# (Optional) You might need to enable mod_rewrite if you use .htaccess for routing
# RUN a2enmod rewrite
# This project doesn't seem to use complex routing or a .htaccess that requires mod_rewrite from what I've seen.
# If it does, the above line would be necessary.
