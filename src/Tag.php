<?php

class Tag
 {
   private $name;
   private $id;

       function __construct($name, $id=null)
       {
         $this->name = $name;
         $this->id = $id;
       }
       function setName($new_name)
       {
           $this->name = (string) $new_name;
       }
       function getName()
       {
           return $this->name;
       }
       function setId($new_id)
       {
           $this->id = (int) $new_id;
       }
       function getId()
       {
           return $this->id;
       }
//ending getter and setter

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO tags (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }
       static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM tags*;");

        }

      static function getAll()
       {
         $return_tags =  $GLOBALS['DB']->query("SELECT * FROM tags");
         $tag_array = array();
         foreach($return_tags as $tag)
         {
             $name = $tag['name'];
             $id = $tag['id'];
             $new_tag = new Tag($name,$id);
             array_push($tag_array, $new_tag);
         }
         return $tag_array;
       }

        static function findById($search_id)
       {
           $statement = $GLOBALS['DB']->query("SELECT * FROM tags WHERE id =$search_id;");
           $tags_id = $statement->fetchAll(PDO::FETCH_ASSOC);
           $tags = null;
           foreach($tags_id as $row)
           {
               $id = $row['id'];
               $name = $row['name'];
               $new_tag = new Tag($name, $id);
               $tags = $new_tag;
           }
           return $tags;
       }
       function getMessages()
       {
           $statement = $GLOBALS['DB']->query("SELECT messages.* FROM tags
           JOIN messages_tags ON(tags.id = messages_tags.tag_id)
           JOIN messages ON (messages.id = message_tags.message_id)
           WHERE tags.id = {$this->getId()};");
           $tags_message = $statement->fetchAll(PDO::FETCH_ASSOC);
           $message_array = array();
           foreach ($tags_message as $message)
           {
               $mess = $message['message'];
               $date = $message['created'];
               $id = $message['id'];
               $user_id = $message['user_id'];
               $new_message = new Message($mess,$date,$user_id,$id);
               array_push($message_array, $new_message);
           }
            return $message_array;


       }





 }




 ?>
