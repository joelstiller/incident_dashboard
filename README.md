# incident_dashboard
This is a PHP driven application that creates a dashboard you can use for major incident communication

# Requirements
- mysql/mariadb server for backend.
- webserver
- php enabled (5x or >)

# Usage

Use the included sql file to create the proper database table setup.

Place the hpi2 directory into your HTTP_ROOT

In your php.ini file include HTTP_ROOT/hpi2 in the path

Edit /hpi2/inc/config.php to include your database info (User/Pass/IP Address)

Once you're up and running the default login is username: admin, password: admin. Once you log in, create your own user account, then edit login.php, and comment out the code that's highlighted between comments. 
