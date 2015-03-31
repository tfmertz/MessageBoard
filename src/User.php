<?php

    class User
    {
        private $name;
        private $isAdmin;
        private $password;
        private $id;

        function __construct($name, $password, $isAdmin = false, $id = null)
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
        function setId($new_id)
        {
            $this->id = $new_id;
        }
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO users (name, admin, password) VALUES ('{$this->getName()}', '{$this->getIsAdmin()}', '{$this->getPassword()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function updatePassword($new_password)
        {
            $GLOBALS['DB']->exec("UPDATE users SET password = '{$new_password}' WHERE id = {$this->getId()};");
            $this->setPassword($new_password);
        }

        function delete()
        {
           $GLOBALS['DB']->exec("DELETE FROM users WHERE id = {$this->getId()};");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM users*;");
        }

        static function getAll()
        {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users");
            $users = [];
            foreach ($returned_users as $user) {
               $name = $user['name'];
               $isAdmin = $user['admin'];
               $password = $user['password'];
               $id = $user['id'];
               $new_user = new User($name, $password, $isAdmin, $id);
               array_push($users, $new_user);
            }
            return $users;
        }

        function getMessages()
        {
            $returned_messages = $GLOBALS['DB']->query("SELECT * FROM messages WHERE user_id = {$this->getId()};");
            $messages = [];
            foreach($returned_messages as $message)
            {
                var_dump($message);
                $text = $message['message'];
                $date = $message['created'];
                $user_id = $message['user_id'];
                $id = $message['id'];
                $new_message = new Message($text, $date, $user_id, $id);
                var_dump($new_message);
                array_push($messages, $new_message);
            }
            var_dump($messages);
            return $messages;
        }

        static function checkAvailable($check_user_name)
        {
            $user_names=[];
            $all_users= User::getAll();

        foreach($all_users as $user){
            $user_name= $user->getName();
            array_push($user_names, $user_name);
        }

        $result = false;
        if (in_array($check_user_name, $user_names, TRUE))
        {
            $result = true;

        }
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
        }

        static function logInCheck($user_name, $password)
        {

            $statement = $GLOBALS['DB']->query("SELECT * FROM users WHERE name = '$user_name' AND password= '$password';");
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            $match_user = null;
            foreach ($results as $result) {
                $match_user = new User($result['name'], $result['password'], $result['admin'], $result['id']);
            }
            return $match_user;



        }


    }

 ?>
