# Use the official PHP image
FROM php:8.2-cli

WORKDIR /app
COPY . .

# Ensure your PHP API has permission to write to your JSON database
RUN touch projects.json && chmod 777 projects.json

# Render assigns a dynamic port, so we bind PHP's built-in server to it
CMD [ "sh", "-c", "php -S 0.0.0.0:$PORT" ]
