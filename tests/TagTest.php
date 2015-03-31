<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

    require_once 'src/Tag.php';

    $DB = new PDO("pgsql:host=localhost;dbname=message_test");


    class TagTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Tag::deleteAll();
        }

             function test_setId()
             {

             }
            function test_getName()
            {
                //arrang
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
                //arrang
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







    }//Ending Tagtest
 ?>
