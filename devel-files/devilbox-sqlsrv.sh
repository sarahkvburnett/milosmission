# Install driver for sqlsrv
# https://github.com/cytopia/devilbox/issues/439

# shell into php container

sudo su -

echo 'debconf debconf/frontend select Noninteractive' | sudo debconf-set-selections
sudo apt-get install -y -q
curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list
exit
sudo apt-get update
sudo ACCEPT_EULA=Y apt-get install -y msodbcsql17

sudo ACCEPT_EULA=Y apt-get install -y mssql-tools

echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
source ~/.bashrc
sudo apt-get install -y unixodbc-dev

# sudo pecl install sqlsrv - installed in PHP 7 versions must be enabled in .env

sudo pecl install pdo_sqlsrv
