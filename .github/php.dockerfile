FROM php:7.4-fpm
RUN set -eux; \
    echo "deb http://mirrors.aliyun.com/debian/ buster main non-free contrib \n \
      deb-src http://mirrors.aliyun.com/debian/ buster main non-free contrib \n \
      deb http://mirrors.aliyun.com/debian-security buster/updates main \n \
      deb-src http://mirrors.aliyun.com/debian-security buster/updates main \n \
      deb http://mirrors.aliyun.com/debian/ buster-updates main non-free contrib \n \
      deb-src http://mirrors.aliyun.com/debian/ buster-updates main non-free contrib \n \
      deb http://mirrors.aliyun.com/debian/ buster-backports main non-free contrib \n \
      deb-src http://mirrors.aliyun.com/debian/ buster-backports main non-free contrib" > /etc/apt/sources.list
# 更新安装依赖包和PHP核心拓展
RUN set -eux; \
    apt-get update && apt-get install -y \
       git \
       bzip2 \
        libzip-dev \
        libbz2-dev \
        libjpeg-dev \
        libpng-dev \
        curl \
        libcurl4-openssl-dev \
        libonig-dev \
        libxml2-dev \
        supervisor  \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        zlib1g-dev \
   && docker-php-ext-install -j$(nproc) gd \
       && docker-php-ext-install zip \
       && docker-php-ext-install pdo_mysql \
       && docker-php-ext-install opcache \
       && docker-php-ext-install mysqli \
       && docker-php-ext-install mbstring \
       && docker-php-ext-install bz2 \
       && docker-php-ext-install soap \
       && rm -r /var/lib/apt/lists/*\
       && usermod -u 1000 www-data\
       && groupmod -g 1000 www-data
# 安装 Composer
ENV COMPOSER_HOME /root/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV PATH $COMPOSER_HOME/vendor/bin:$PATH