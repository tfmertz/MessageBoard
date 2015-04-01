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

        function test_save_time()
        {

        }

        function test_save_now()
        {
            
        }

        function testGetMessage()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
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
            $date = "2014-11-11 12:45:34";
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
            $date = "2014-11-11 12:45:34";
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
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            //Act
            $test_message->setDate("2014-11-13 12:45:34");
            $result = $test_message->getDate();
            //Assert
            $this->assertEquals("2014-11-13 12:45:34", $result);
        }


        function testGetMessageId()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            $test_message->save();


            //Act
            $result = $test_message->getMessageId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testsetMessageId()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);

            //Act
            $result = $test_message->setMessageId(5);

            //Assert
            $result = $test_message->getMessageId();
            $this->assertEquals(5, $result);
        }

        function testGetAll()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            $test_message->save();

            $message2 = "Going to movie tomorrow";
            $date2 = "2014-11-10 12:45:34";
            $user_id = 3;
            $test_message2 = new Message($message2,$date2,$user_id);
            $test_message2->save();

            //Act
            $result = Message::getAll();

            //Assert
            $this->assertEquals([$test_message,$test_message2], $result);
        }

        function testSave()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            $test_message->save();

            //Act
            $result = Message::getAll();

            //Assert
            $this->assertEquals([$test_message], $result);

        }

        function testDeleteAll()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            $test_message->save();

            $message2 = "Going to movie tomorrow";
            $date2 = "2014-11-10 12:45:34";
            $user_id = 3;
            $test_message2 = new Message($message2,$date2,$user_id);
            $test_message2->save();

            //Act
             Message::deleteAll();

            //Assert
            $result = Message::getAll();
            $this->assertEquals([ ], $result);
        }

        function testFind()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            $test_message->save();

            $message2 = "Going to movie tomorrow";
            $date2 = "2014-11-10 12:45:34";
            $user_id = 3;
            $test_message2 = new Message($message2,$date2,$user_id);
            $test_message2->save();

            //Act
            $result = Message::find($test_message2->getMessageId());

            //Assert
            $this->assertEquals($test_message2, $result);
        }


        function testUpdate()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            //Act
            $test_message->update("Going to movie today evening");
            $result = $test_message->getMessage();
            //Assert
            $this->assertEquals("Going to movie today evening", $result);
        }

        function testAddTags()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            $test_message->save();

            $tag_name = "Entertainment";
            $test_tag = new Tag($tag_name);
            $test_tag->save();
            //Act
            $test_message->addTag($test_tag);

            //Assert
            $result = $test_message->getTags();
            $this->assertEquals([$test_tag], $result);
        }

        function testGetTags()
        {
            //Arrange
            $message = "Going to movie tomorrow";
            $date = "2014-11-11 12:45:34";
            $user_id = 3;
            $test_message = new Message($message,$date,$user_id);
            $test_message->save();

            $tag_name = "Entertainment";
            $test_tag = new Tag($tag_name);
            $test_tag->save();

            $tag_name2 = "Having fun";
            $test_tag2 = new Tag($tag_name2);
            $test_tag2->save();
            //Act
            $test_message->addTag($test_tag);
            $test_message->addTag($test_tag2);

            //Assert
            $result = $test_message->getTags();
            $this->assertEquals([$test_tag, $test_tag2], $result);
        }



    }
