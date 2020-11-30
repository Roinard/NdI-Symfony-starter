use mysql;
CREATE USER 'app'@'localhost' IDENTIFIED BY 'maria_pass_app';
GRANT ALL PRIVILEGES ON * . * TO 'app'@'localhost';
FLUSH PRIVILEGES;
