FROM debian:buster

RUN bash -c 'debconf-set-selections <<< "mariadb-server mysql-server/root_password password maria_pass_app"'
RUN bash -c 'debconf-set-selections <<< "mariadb-server mysql-server/root_password_again password maria_pass_app"'

RUN apt-get update && \
    apt-get install -y apache2 curl php libapache2-mod-php php-cli mariadb-server php-mysql php-xml php-mbstring && \
    rm -rf /var/lib/apt/lists/*

ADD app.conf /etc/apache2/sites-available/app.conf
ADD ./init_script.sh /root
ADD ./root_password.sql /root

#RUN mysql < /root/root_password.sql

RUN mkdir -p /var/www/app
RUN mkdir /logs

RUN a2ensite app
RUN a2enmod rewrite
RUN a2dissite 000-default
RUN echo "127.0.0.1 app.local" >> /etc/hosts


WORKDIR /root
RUN chmod +x init_script.sh

EXPOSE 80
EXPOSE 3306

CMD [ "/root/init_script.sh" ]