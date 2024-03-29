# Fibenis Installation Guide

Welcome to the Fibenis Framework Installation Guide. Follow the steps below to set up your Fibenis-powered web application effortlessly.

## Overview

Fibenis is an adaptive and full-stack PHP web framework developed by Webstars. It offers a streamlined communication pattern, making it a versatile solution for building web applications.

### Key Features:

- **Adaptive Architecture:** Seamlessly adapts to various systems and technologies.
  
- **Full Stack:** Covers both front-end and back-end development needs.

## Installation Steps

1. **Create Application Folder**
   - Establish a folder named `webapp` to serve as the application's home.

2. **Organize Files**
   - Relocate the `fibenis` folders from `def` to `theme`, and move five other essential files into the `webapp` directory.

3. **Database Setup**
   - Access the `doc/db` folder, which contains crucial SQL files:
     - `fibenis_nano_0.0.sql`
     - `fibenis_nano_0.1.sql`
   - Initialize a database, preferably named `webapp`, to manage application data.

4. **Import SQL Files**
   - If employing phpMyAdmin:
     - Import the SQL files sequentially: `fibenis_nano_0.0.sql` followed by `fibenis_nano_0.1.sql`.
   - For command-line interface usage:
     ```bash
     mysql -h localhost -u root <db_name> < doc/db/fibenis_nano_0.0.sql
     mysql -h localhost -u root <db_name> < doc/db/fibenis_nano_0.1.sql
     ```

5. **Configuration**
   - Update database information and application server path within `fE7zRhHqYfSLT9CRm55cBPGHjAGuhqhhjKGSZrB.php`:
     ```php
     "host"          => "localhost",
     "db_name"       => '<db_name>',
     "user"          => '<db_user_name>',
     "pass"          => "<db_password>",
     "domain_name"   => "https://localhost/webapp"
     ```

6. **File Permissions (For Linux OS)**
   - Adjust permissions for executable files:
     ```bash
     chmod 755 index.php
     chmod 755 router.php
     chmod 777 terminal
     ```

7. **Verify Setup**
   - Access the application through `https://localhost/webapp`.
   - You'll be prompted for login credentials.

   Default Login Credentials:
   - **Username:** sa@webstarscg.com
   - **Password:** test

## SQL Commands

```sql
-- Enable Function Creator Permission
SET GLOBAL log_bin_trust_function_creators = 1;

-- Create Database
CREATE DATABASE <db_name>;

-- Import SQL Files
mysql -h localhost -u root <db_name> < doc/db/fibenis_nano_0.0.sql
mysql -h localhost -u root <db_name> < doc/db/fibenis_nano_0.1.sql

-- Create User
CREATE USER '<user>'@'<host_name>' IDENTIFIED BY '<password>';
GRANT ALL PRIVILEGES ON *.* TO '<user>'@'<host_name>' WITH GRANT OPTION;
