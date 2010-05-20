Kohana 2.3.4 & Gearman Example Project
======================================

This is a sample project using Gearmand, Gearman PHP extension from PECL and Kohana 2.3.4 to show the speed increases possible for the front end user interface when sending emails.

You will need to update the application/config/email.php with a valid SMTP host / user / password / etc.

If your gearmand is running on a different port and server you will need to alter this in application/config/gearman.php

You will also need to compile the gearman server & PHP module for it - please see the presentation at http://www.ukd1.co.uk/blog/2010/05/gearman-kohana-an-introduction/

To run the worker, open a shell and change to the folder with the code in and execute;

php index.php "gearman/workers"

