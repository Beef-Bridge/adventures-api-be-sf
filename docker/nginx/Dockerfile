FROM nginx:1.25.2-alpine3.18

WORKDIR /etc/nginx/conf.d
COPY conf.d/default.conf  /etc/nginx/conf.d/default.conf

WORKDIR /var/www

EXPOSE 80
EXPOSE 443
