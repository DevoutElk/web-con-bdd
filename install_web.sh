#!/bin/bash
set -e

echo "==> Actualizando paquetes..."
apt update

echo "==> Instalando Apache y PHP..."
apt install -y apache2 php php-mysqli php-pdo php-pdo-mysql libapache2-mod-php git

echo "==> Habilitando Apache..."
systemctl enable apache2
systemctl start apache2

echo "==> Descargando aplicación desde repositorio..."
rm -rf /var/www/html/*
git clone https://github.com/DevoutElk/web-con-bdd /var/www/html/

echo "==> Ajustando permisos..."
chown -R www-data:www-data /var/www/html/
chmod -R 755 /var/www/html/

echo "==> Reiniciando Apache..."
systemctl restart apache2


echo "==> Creando fichero .env..."
cat > /var/www/html/.env <<EOF
DB_HOST=${DB_HOST:-10.0.0.30}
DB_NAME=${DB_NAME:-appdb}
DB_USER=${DB_USER:-appuser}
DB_PASS=${DB_PASS}
EOF
chmod 600 /var/www/html/.env


echo "==> Instalación completa!"
echo "    Web disponible en http://$(hostname -I | awk '{print $1}')"
