<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Message.php";
    require_once "src/Tag.php";
    require_once "src/User.php";

    $DB = new PDO('pgsql:host=localhost;dbname=message_test');
    class MessageTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Message::deleteAll();
            Tag::deleteAll();
        }

        function testGetMessage()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = 2014-11-11 12:45:34;
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);

            //Act
            $result = $test_message->getMessage();

            //Assert
            $this->assertEquals($message, $result);
        }
        function testSetMessage()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = 2014-11-11 12:45:34;
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            //Act
            $test_message->setMessage("Going to movie today evening");
            $result = $test_message->getMessage();
            //Assert
            $this->assertEquals("Going to movie today evening", $result);
        }

        function testGetDate()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = 2014-11-11 12:45:34;
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);

            //Act
            $result = $test_message->getDate();

            //Assert
            $this->assertEquals($date, $result);
        }

        function testSetDate()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = 2014-11-11 12:45:34;
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            //Act
            $test_message->setDate(2014-11-13 12:45:34);
            $result = $test_message->getDate();
            //Assert
            $this->assertEquals(2014-11-13 12:45:34, $result);
        }


























?>
