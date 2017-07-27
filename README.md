# PhotoDownload

Для работы с api vk использовано OpenVPN. Установка и запуск OpenVPN:
1. sudo apt-get update
2. sudo apt-get install openvpn easy-rsa
3. sudo python <путь к тестовому заданию>/OpenVPN/vpn.py US

Настройка подключения к базе данных app/DatabaseConnection.php;

Запуск миграций: sudo php <путь к тестовому заданию>/migrate.php

Запуск скрипта: php <путь к тестовому заданию>/index.php app:download-photo <user_id> --dir=<directory_to_save>
