# incident_dashboard
This is a PHP driven application that creates a dashboard you can use for major incident communication

# Requirements
- mysql/mariadb server for backend.
- webserver
- php enabled (5x or >)

# Usage

Use the included sql file to create the proper database table setup.

Place the hpi2 directory into your HTTP_ROOT

In your php.ini file include HTTP_ROOT/hpi2 in the path, also you need to set your timezone 

Ex.
```
[Date]
; Defines the default timezone used by the date functions
; http://php.net/date.timezone
date.timezone = America/New_York
```
Edit /hpi2/inc/config.php to include your database info (User/Pass/IP Address)

Once you're up and running the default login is username: admin, password: admin. Once you log in, create your own user account, then edit login.php, and comment out the code that's highlighted between comments. 

# Working Example
http://ec2-18-212-69-11.compute-1.amazonaws.com/hpi2/index.php
