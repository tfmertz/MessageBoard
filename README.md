
## MessageBoard

###### March 30, 2015

##### Virginie Trubino, Chitra Atmakuru, Nhu Finney, Tom Mertz, Conor Baumgart, Tommy Bountham


#### Description

A simple message board app where users can input an event message and a group of users who know each other can view them and engage in social activities.

####Setup instructions

1.  **Clone this git repository:**

  1.1 Copy the repo remote address  https://github.com/tfmertz/MessageBoard from the bottom right side under **HTTPS clone URL**

  1.2 Run a `git clone https://github.com/tfmertz/MessageBoard` in a terminal window

2.  **Use Composer to install required dependencies in the composer.json file:**

    2.1 In terminal window, change to the MessageBoard directory using `cd MessageBoard/`

    2.2 Install the dependencies in the composer.json file by typing `composer install`

3.  **Import the database schema:**

    3.1 Open a new terminal tab and start your postgres database by typing `postgres`

    3.2 Open a new terminal tab/window and type `psql` to enter the database command line

    3.3 Create a database named *message_board* by typing `CREATE DATABASE message_board;`

    3.4 Connect to the database with `\c message_board`

    3.5 Import the development database schema with `\i message_board.sql`

    3.6 Create the test database by running the SQL query `CREATE DATABASE message_test WITH TEMPLATE message_board;`

4.  **Set up your development server**

    4.1 In a new terminal tab/window, navigate to the `web` folder inside the `MessageBoard/` main project directory

    4.2 Start a php server by typing `php -S localhost:8000`

    4.3 Open a web browser and connect to the address `http://localhost:8000/`

#### Troubleshooting

If the database schema import doesn't work you can manually create the Postgres database on your local machine using the following Postgres commands.

**Note:** The application has **not** been tested to work with MySQL.

```sql
  CREATE DATABASE message_board;

  \c message_board

  CREATE TABLE messages (id serial PRIMARY KEY, message varchar, created timestamp, user_id int);
  CREATE TABLE tags (id serial PRIMARY KEY, name varchar);
  CREATE TABLE users (id serial PRIMARY KEY, name varchar, password varchar, admin boolean);
  CREATE TABLE messages_tags (id serial PRIMARY KEY, message_id int, tag_id int);

  CREATE DATABASE message_test WITH TEMPLATE message_board;
```

If the database is throwing Connection refused exceptions, try editing the PDO instantiation line to include the username and password of the postgres user the message_board database was created by.


**app.php line 10** before revision

```php
<?php
#...
$DB = new PDO('pgsql:host=localhost;dbname=message_board');
```

**app.php line 10** with user and pass

```php
<?php
#...
$DB = new PDO('pgsql:host=localhost;dbname=message_board',
  "<your_username>", "<your_password>");
```

#### Database Schema

![alt text] (https://github.com/tfmertz/MessageBoard/blob/master/schema/schema-image.png)

####Technologies used

* HTML5

* CSS3

* Bootstrap ver 3.3.1

* PHP (tested to run on PHP ver 5.6.6)

* Silex ver 1.2.3

* Twig ver 1.18.0

* PHPUnit ver 4.5.0

* PostgreSQL ver 9.4.1

###ENJOY THE APP!!!
---
#### Licenses

##### Copyright © 2015 Tom Mertz, Virginie Trubino, Chitra Atmakuru, Nhu Finney, Conor Baumgart, Tommy Bountham

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
