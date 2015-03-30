<?php

    class User
    {
        private $name;
        private $isAdmin;
        private $password;
        private $id;

        function __construct($name, $isAdmin, $password, $id = null)
        {
            $this->name = $name;
            $this->isAdmin = $isAdmin;
            $this->password = $password;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }
        function getIsAdmin()
        {
            return $this->isAdmin;
        }
        function getPassword()
        {
            return $this->password;
        }
        function getId()
        {
            return $this->id;
        }
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }
        function setIsAdmin($new_admin)
        {
            $this->isAdmin = (boolean) $new_admin;
        }
        function setPassword($new_password)
        {
            $this->password = (string) $new_password;
        }
    }






 ?>
