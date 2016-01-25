<?php

class User
{
    private $name;
    private $isAdmin;
    private $password;
    private $id;

    function __construct($name, $password, $isAdmin = 'false', $id = null)
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
        $statement = $GLOBALS['DB']->prepare("INSERT INTO users (name, admin, password) VALUES (:name, '{$this->getIsAdmin()}', :password) RETURNING id;");
        $statement->bindParam(':name', $this->getName());
        $statement->bindParam(':password', $this->getPassword());
        $statement->execute();
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
        $GLOBALS['DB']->exec("DELETE FROM users *;");
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
            $text = $message['message'];
            $date = $message['created'];
            $user_id = $message['user_id'];
            $id = $message['id'];
            $new_message = new Message($text, $date, $user_id, $id);
            array_push($messages, $new_message);
        }
        return $messages;
    }

    static function checkAvailable($check_user_name)
    {
        $statement = $GLOBALS['DB']->prepare("SELECT * FROM users WHERE name = :name;");
        $statement->bindParam(':name', $check_user_name);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return empty($results);
    }

    static function logInCheck($user_name, $password)
    {
        $statement = $GLOBALS['DB']->prepare("SELECT * FROM users WHERE name = :name");
        $statement->bindParam(':name', $user_name);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $match_user = null;
        foreach ($results as $result) {
            if(password_verify($password, $result['password'])) {
                $match_user = new User($result['name'], $result['password'], $result['admin'], $result['id']);
            }
        }
        return $match_user;
    }

    static function find($search_id)
    {
        $st = $GLOBALS['DB']->prepare("SELECT * FROM users WHERE id = :id;");
        $st->bindParam(':id', $search_id);
        $st->execute();

        $found_user = null;
        while($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $found_user = new User($row['name'], $row['password'], $row['admin'], $row['id']);
        }
        return $found_user;
    }
}
