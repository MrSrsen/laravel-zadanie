FROM php:8.2-cli-alpine3.21

ARG USERID=1000
ARG GROUPID=1000
ARG USERNAME=laravel
ARG APPLICATION_VERSION=dev

ENV USERID=${USERID}
ENV GROUPID=${GROUPID}
ENV USERNAME=${USERNAME}
ENV APPLICATION_VERSION=${APPLICATION_VERSION}

COPY --from=composer:2.8.3 /usr/bin/composer /usr/local/bin/composer

RUN apk add --no-cache busybox-suid sudo curl bash git libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && addgroup -g ${GROUPID} ${USERNAME} \
    && adduser -D --home /home/${USERNAME}  --ingroup ${USERNAME} --uid ${USERID} ${USERNAME} \
    && adduser ${USERNAME} wheel \
    && touch /etc/sudoers \
    && sed -e 's;^# \(%wheel.*NOPASSWD.*\);\1;g' -i /etc/sudoers \
    && bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
