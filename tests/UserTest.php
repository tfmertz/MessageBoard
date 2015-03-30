<?php


/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

    require_once 'src/User.php';

    //add DB initialization later

    class UserTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        // {
        //
        // }

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
    }



 ?>
