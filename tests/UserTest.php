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
    }



 ?>
