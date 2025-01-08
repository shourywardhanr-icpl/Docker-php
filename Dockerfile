FROM centos:7

# Update repository to use vault
RUN sed -i 's/mirrorlist/#mirrorlist/g' /etc/yum.repos.d/CentOS-* && \
    sed -i 's|#baseurl=http://mirror.centos.org|baseurl=http://vault.centos.org|g' /etc/yum.repos.d/CentOS-*

# Install EPEL and minimal required dependencies
RUN yum install -y epel-release && \
    yum update -y && \
    yum install -y \
    gcc \
    make \
    wget \
    tar \
    libxml2-devel \
    openssl-devel \
    mariadb-devel \
    httpd-devel \
    libmcrypt-devel \
    && yum clean all && \
    rm -rf /var/cache/yum

# Download and compile PHP with minimal extensions
RUN wget https://museum.php.net/php5/php-5.6.8.tar.gz && \
    tar -xzf php-5.6.8.tar.gz && \
    cd php-5.6.8 && \
    ./configure \
    --prefix=/usr \
    --with-config-file-path=/etc \
    --with-apxs2=/usr/bin/apxs \
    --with-mysql \
    --with-mysqli \
    --with-pdo-mysql \
    --with-mcrypt \
    --with-openssl \
    --enable-mbstring \
    && make \
    && make install \
    && rm -rf php-5.6.8*

# Basic PHP configuration
RUN mkdir -p /etc/php.d && \
    echo "date.timezone = UTC" > /etc/php.ini && \
    echo "memory_limit = 128M" >> /etc/php.ini

# Install and configure Apache
RUN yum install -y httpd && \
    yum clean all && \
    echo "ServerName localhost" >> /etc/httpd/conf/httpd.conf

# Test file with "Hello World"
COPY info.php /var/www/html/info.php

EXPOSE 80

CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]