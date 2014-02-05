cms-app
=======

A simple CMS app I made to learn PHP and MySQL.

Much of the code for the navigation and queries was created using the lynda.com course; PHP with MySQL Essential Training (http://www.lynda.com/MySQL-tutorials/PHP-MySQL-Essential-Training/119003-2.html).

If you'd like you can say what's up via shanewilliamswebdev.com

Cheers!



INSTALL INSTRUCTIONS:


1. Upload the public and includes folders to your server.

2. Point the domain to the 'public' folder using .htaccess, or point a subdomain's path to the 'public' folder. Example "public_html/'sub folder'/public".

3. Create a new Database and Database User for your content to be stored in, make sure the user is connected to the db and allowed all privileges.

4. Change the db_connect.php file contained in the 'includes' folder to represent the database and database user and password you created.

5. Run the install.php file. Example 'domain.com'/install.php. If you are waiting for a subdomain to propogate you may not get the success message and will need to browse to 'domain.com'/index.php. The CMS is now installed the default user is 'root' and the password is 'root' 

6. Delete the install.php and change the password.
