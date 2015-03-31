<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

    require_once 'src/Tag.php';
    require_once 'src/Message.php';


    $DB = new PDO("pgsql:host=localhost;dbname=message_test");

    class TagTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Tag::deleteAll();
        }

            function test_getMessage()
            {

            }

             function test_finByid()
             {
                 //arrange
                 $test_tag = new Tag("Tommy");
                 $test_tag->save();

                 //act
                 $search_id = $test_tag->getId();
                 $result = Tag::findById($search_id);

                 //assert
                 $this->assertEquals($test_tag, $result);
             }
             function test_getId()
             {
                 //arrange
                 $name = "vone";
                 $id = 2;
                 $test_tags = new Tag($name,$id);

                 //act
                 $result = $test_tags->getId(2);

                 //assert
                 $this->assertEquals(2, $result);


             }

             function test_setId()
             {
                //arrange
                $name = "Tomm";
                $id = 1;
                $test_tags = new Tag($name,$id);
                $new_id = 2;

                //act
                $test_tags->setId($new_id);
                $result = $test_tags->getId();

                //asser
                $this->assertEquals($new_id, $result);

             }
            function test_getName()
            {
                //arrange
                $name = "tommy";
                $id = null;
                $test_tags = new Tag($name,$id);

                //act
                $result = $test_tags->getName();

                //assert
                $this->assertEquals($name,$result);


            }

            function test_setName()
            {
                //arrange
                $name = "Vone";
                $id = null;
                $test_tags = new Tag($name, $id);
                $new_name = "Tom";

                //act
                $test_tags->setName($new_name);
                $result = $test_tags->getName();

                //assert

                $this->assertEquals("Tom", $result);
            }



            function test_deleteAll()
            {
                //arrange
                $name = "Connor";
                $id = null;
                $test_tags = new Tag($name,$id);
                $test_tags->save();

                $name2 = "Tom";
                $id2 = null;
                $test_tags2 = new Tag($name2,$id2);
                $test_tags2->save();

                //act
                Tag::deleteAll();

                //assert
                $result = Tag::getAll();
                $this->assertEquals([],$result);

              }
              function test_getAll()
              {
                  //arrange
                  $name = "Ricky";
                  $id = null;
                  $test_tags = new Tag($name,$id);
                  $test_tags->save();

                  $name2 = "Vin";
                  $id2 = null;
                  $test_tags2 = new Tag($name2,$id2);
                  $test_tags2->save();

                  //act
                  $result = Tag::getAll();

                  //assert
                  $this->assertEquals([$test_tags,$test_tags2], $result);

              }

              function test_save()
              {
                  //arrange
                  $name = "Connor";
                  $id = null;
                  $test_tags = new Tag($name,$id);
                  $test_tags->save();

                  //act
                  $result = Tag::getAll();

                  //assert
                  $this->assertEquals([$test_tags], $result);
              }

             function test_getMessages()
             {
                     $user_id = 10;
                     $date = "2008-11-11 13:23:44";
                     $text = "where are you coming from";
                     $message = new Message($text,$date,$user_id);
                     $message->save();

                     $name = "Bar";
                     $test_tag = new Tag($name);
                     $test_tag->save();
                     $test_tag->addMessage($message);

                     $result = $test_tag->getMessages();

                     $this->assertEquals([$message], $result);


             }






    }//Ending Tagtest
 ?>
