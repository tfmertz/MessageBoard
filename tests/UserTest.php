<?php


/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

    require_once 'src/User.php';
    require_once 'src/Message.php';

    //add DB initialization later

    class UserTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
         {
            User::deleteAll();
            //Mesage::deleteAll();
         }

        function test_getName()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);

            $result = $test_user->getName();

            $this->assertEquals("Tyler", $result);
        }

        function test_getIsAdmin()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);

            $result = $test_user->getIsAdmin();

            $this->assertEquals(true, $result);
        }

        function test_getPassword()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);

            $result = $test_user->getPassword();

            $this->assertEquals("howdy", $result);
        }

        function test_getId()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $id = 1;
            $test_user = new User($name, $isadmin, $password, $id);

            $result = $test_user->getId();

            $this->assertEquals(1, $result);
        }

        function test_setName()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);
            $new_name = "Taylor";

            $test_user->setName($new_name);
            $result = $test_user->getName();

            $this->assertEquals("Taylor", $result);

        }

        function test_setIsAdmin()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);
            $new_isadmin = false;

            $test_user->setIsAdmin($new_isadmin);
            $result = $test_user->getIsAdmin();

            $this->assertEquals(false, $result);
        }

        function test_setPassword()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);
            $new_password = "hey there";

            $test_user->setPassword($new_password);
            $result = $test_user->getPassword();

            $this->assertEquals("hey there", $result);
        }

        function test_setId()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);
            $new_id = 45;

            $test_user->setId($new_id);
            $result = $test_user->getId();

            $this->assertEquals(45, $result);
        }

        function test_save()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);
            $test_user->save();

            $result = User::getAll();

            $this->assertEquals([$test_user], $result);
        }

        function test_getAll()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);
            $test_user->save();

            $name2 = "Richard";
            $password2 = "bouh";
            $test_user2 = new User($name2, $isadmin, $password2);
            $test_user2->save();


            $result = User::getAll();

            $this->assertEquals([$test_user, $test_user2], $result);
        }

        // function test_updatePassword()
        // {
        //     $name = "Tyler";
        //     $isadmin = true;
        //     $password = "howdy";
        //     $test_user = new User($name, $isadmin, $password);
        //     $new_password = 'rebouh';
        //
        //     $test_user->updatePassord($new_id);
        //     $result = $test_user->getPassword();
        //
        //     $this->assertEquals($new_password, $result);
        // }

        function test_getMessages()
        {
            $name = "Tyler";
            $isadmin = true;
            $password = "howdy";
            $test_user = new User($name, $isadmin, $password);

            $text = 'bla bla plein de chose à dire';
            $message = new Message($text);
            $message->save();

            $result = $test_user->getMessages();

            $this->assertEquals([$message], $result);
        }

    }



 ?>
