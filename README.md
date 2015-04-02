
## MESSAGE BOARD

###### March 30, 2015


#### Description

A simple message board app where users can input an event message and a group of users who know each other can view them and engage in social activities.

#### Database Schema

![alt text] (https://github.com/tfmertz/MessageBoard/blob/master/schema/schema-image.png)

#### Licenses

Copyright (c) 2015 Tom Mertz, Tommy Bountham, Conor Baumgart, Virginie Trubiano, Nhu Finney, Chitra Atmakuru

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

####Setup instructions

1.  Clone this git repository:

  1.1 Go the Github page: https://github.com/tfmertz/MessageBoard;

  1.2 In the right bottom side, choose "HTTPS clone URL" or "Clone in Desktop";

2.  Use Composer to install required dependencies in the composer.json file:

    2.1 In terminal window, move to inside the folder "MessageBoard" by "\c MessageBoard";

    2.2 Run install composer by "composer install";

3.  Import data:

    3.1 In a terminal window, go into the MessageBoard folder, start Postgres by "postgres";

    3.2 Open a new terminal window, run "psql";

    3.3 Create a database named MessageBoard by "CREATE DATABASE message_board;"

    3.4 Go inside the messageboard by "\c message_board";

    3.5 Import database by "\i messega_board.sql".

4.  Set your localhost root folder to the MessageBoard folder

    4.1 In another new terminal window, move to inside folder MessageBoard by "\cd MessageBoard\web";

    4.2 Run localhost by "php -S localhost:8000";

    4.3 Open a web browser and address to (http://localhost:8000/)


####Copyright © 2015, Epicodus.com

####License: www.epicodus.com

######Technologies used

* HTML5

* CSS3

* Bootstrap ver 3.3.1

* PHP (tested to run on PHP ver 5.6.6)

* Silex ver 1.2.3

* Twig ver 1.18.0

* PHPUnit ver 4.5.0

* PostgreSQL ver 9.4.1

ENJOY THE APP!!!
