# How To Install Linux, Apache, MySQL, PHP (LAMP) Stack on Linux/Ubuntu and WSL

## Introduction
The LAMP stack is a set of open-source software that is typically installed together to enable a server to host dynamic websites and web apps. LAMP stands for:
- **L**inux (the operating system)
- **A**pache (the web server)
- **M**ySQL (the database management system)
- **P**HP (the programming language)

In this guide, we’ll install a LAMP stack on an Ubuntu 22.04 server, applicable to both traditional Linux and Windows Subsystem for Linux (WSL).

## Step 1 — Installing Apache and Adjusting the Firewall

### Installing Apache
1. Update your package index:
    ```sh
    sudo apt update
    ```
2. Install Apache:
    ```sh
    sudo apt install apache2
    ```
3. Verify Apache installation:
    ```sh
    sudo apache2ctl configtest
    ```

### Setting Global ServerName to Suppress Syntax Warnings
1. Open the Apache configuration file:
    ```sh
    sudo nano /etc/apache2/apache2.conf
    ```
2. Add the `ServerName` directive to the end of the file:
    ```sh
    ServerName server_domain_or_IP
    ```
3. Save and close the file, then restart Apache:
    ```sh
    sudo systemctl restart apache2
    ```

### Adjusting the Firewall to Allow Web Traffic
For traditional Linux:
1. Check available UFW application profiles:
    ```sh
    sudo ufw app list
    ```
2. Allow incoming traffic for the Apache Full profile:
    ```sh
    sudo ufw allow in "Apache Full"
    ```

For WSL:
- Ensure your Windows firewall allows traffic on the necessary ports (80 for HTTP, 443 for HTTPS).

Verify Apache installation by visiting your server’s public IP address in your web browser (`http://your_server_IP_address`).

## Step 2 — Installing MySQL
1. Install MySQL server:
    ```sh
    sudo apt install mysql-server
    ```
2. Run the MySQL security script:
    ```sh
    sudo mysql_secure_installation
    ```
    - Set a strong password for the MySQL root user.
    - Answer `Y` to all subsequent prompts to remove anonymous users, disallow root login remotely, remove the test database, and reload privilege tables.

## Step 3 — Installing PHP
1. Install PHP and required modules:
    ```sh
    sudo apt install php php-cgi php-mysqli php-pear php-mbstring libapache2-mod-php php-common php-phpseclib php-mysql -y
    ```
2. Adjust Apache to prefer PHP files:
    ```sh
    sudo nano /etc/apache2/mods-enabled/dir.conf
    ```
    - Move `index.php` to the first position after `DirectoryIndex`:
    ```apache
    <IfModule mod_dir.c>
        DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
    </IfModule>
    ```
3. Restart Apache:
    ```sh
    sudo systemctl restart apache2
    ```

## Step 4 — Testing PHP Processing on your Web Server
1. Create a PHP test file:
    ```sh
    sudo nano /var/www/html/info.php
    ```
    - Add the following content:
    ```php
    <?php
    phpinfo();
    ?>
    ```
2. Visit `http://your_server_IP_address/info.php` to test PHP.

Remove the test file after confirming PHP works:
    ```sh
    sudo rm /var/www/html/info.php
    ```

## Step 5 — Installing and Configuring phpMyAdmin
1. Install phpMyAdmin:
    ```sh
    sudo apt install phpmyadmin
    ```
    - During installation, select Apache for the web server.
    - Configure database for phpMyAdmin with dbconfig-common and provide the necessary details.

2. Enable phpMyAdmin configuration in Apache:
    ```sh
    sudo ln -s /usr/share/phpmyadmin /var/www/html/phpmyadmin
    ```
3. Restart Apache:
    ```sh
    sudo systemctl restart apache2
    ```

## Step 6 — Managing Services

### Starting Services
- Start Apache:
    ```sh
    sudo systemctl start apache2
    ```
- Start MySQL:
    ```sh
    sudo systemctl start mysql
    ```

### Stopping Services
- Stop Apache:
    ```sh
    sudo systemctl stop apache2
    ```
- Stop MySQL:
    ```sh
    sudo systemctl stop mysql
    ```

### Restarting Services
- Restart Apache:
    ```sh
    sudo systemctl restart apache2
    ```
- Restart MySQL:
    ```sh
    sudo systemctl restart mysql
    ```

## Step 7 — Accessing Your Web Server and phpMyAdmin

### Access your web server:
- Open a web browser and navigate to `http://localhost`.

### Access phpMyAdmin:
- Open a web browser and go to `http://localhost/phpmyadmin`.
- Use your MySQL root credentials to log in.

## Step 8 — Adding Your Web Files
1. Navigate to the web directory:
    ```sh
    cd /var/www/html
    ```
2. Add your web files:
    - Copy your web project files to this directory. For example:
    ```sh
    cp -r /path/to/your/project/* /var/www/html/
    ```

3. Set permissions (if necessary):
    ```sh
    sudo chown -R www-data:www-data /var/www/html
    sudo chmod -R 755 /var/www/html
    ```

## Step 9 — Automating Service Start
1. Edit `.bashrc`:
    ```sh
    nano ~/.bashrc
    ```
2. Add the following lines to the end of the file:
    ```sh
    # Start Apache and MySQL automatically
    sudo service apache2 start
    sudo service mysql start
    ```
3. Save and exit:
    - Press `Ctrl+O` to save the file.
    - Press `Ctrl+X` to exit the editor.

4. Reload `.bashrc`:
    ```sh
    source ~/.bashrc
    ```

## Troubleshooting
### Check logs:
- If you encounter issues, check the logs located in `/var/log/apache2/` for Apache and `/var/log/mysql/` for MySQL.

### Port conflicts:
- Ensure that no other services (like another instance of Apache or MySQL) are running on the same ports used by your LAMP stack. You can change the ports by editing the configuration files if necessary.

## Notes for WSL Users
- When using WSL, you might need to adjust configurations to handle network interfaces and port access properly.
- Ensure WSL is set to version 2 for better performance and compatibility:
    ```sh
    wsl --set-version <distro> 2
    ```
- To access the web server from your Windows browser, you can usually use `localhost` or find the WSL IP address by running:
    ```sh
    hostname -I
    ```
