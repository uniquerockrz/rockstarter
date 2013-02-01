![Typical output](https://raw.github.com/uniquerockrz/rockstarter/master/screen1.png)
![Typical output](https://raw.github.com/uniquerockrz/rockstarter/master/screen2.png)

Simple Men At Work, Under Construction Page

* Upload the files in your server
* Change the values of 

define ('__DOCROOT__', '');
			define ('__VIRTUAL_DIRECTORY__', '');
			define ('__SUBDIRECTORY__', '');

and

define('DB_CONNECTION_1', serialize(array(
				'adapter' => 'MySqli5',
				'server' => 'localhost',
				'port' => null,
				'database' => '',
				'username' => '',
				'password' => '',
				'caching' => false,
				'profiling' => false)));

In qcubed/includes/configuration/configuration.inc.php

* Create the database and run the commands in run.sql
