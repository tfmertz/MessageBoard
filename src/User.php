<?php

    class User
    {
        private $name;
        private $isAdmin;
        private $password;
        private $id;

        function __construct($new_name, $isAdmin, $password, $id = null)
        {
            $this->name = $new_name;
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
            $statement = $GLOBALS['DB']->query("INSERT INTO users (name, isAdmin, password) VALUES ('{$this->getName()}', '{$this->getIsAdmin()}', '{$thiq->getPassword()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function updatePassword($new_password)
        {
            //$GLOBALS['DB']->exec("UPDATE users SET password = '$new_password' WHERE id = {$this->getId()}");
        }

        //function delete()
        //{
        //    $GLOBALS['DB']->exec("DELETE FROM users (name, ");
        //}

        static function deleteALL()
        {
            $GLOBALS['DB']->exec("DELETE FROM users*;");
        }

        static function getAll()
        {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users");
            $users = [];
            foreach ($returned_users as $user) {
               $name = $user['name'];
               $isAdmin = $user['isAdmin'];
               $password = $user['password'];
               $id = $user['id'];
               $new_user = new User(name, isAdmin, password, id);
               array_push($users, $new_user);
            }
            return $users;
        }

        function getMessages()
        {
            $statement = $GLOBALS['DB']->query("SELECT messages.* FROM users
                                    JOIN users_messages ON (users.id = users_messages.user_id)
                                    JOIN messages ON (messages.id = users_messages.message_id)
                                    WHERE id = {$this->getId()};");
            $returned_messages = $statement->fetAll(PDO::FETCH_ASSOC);
            $messages = [];
            foreach($returned_messages as $message)
            {
                $text = $message['text'];
                $id = $message['id'];
                $new_message = new Message($text, $id);
                array_push($messages, $new_message);
            }
            return $messages;
        }




    }

 ?>
