<?php


 class Tag
 {
   private $name;
   private $id;

       function __construct($name,$id=null)
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
      function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE FROM tags*;");

      }
      function getAll()
      {
         $return_tags =  $GLOBALS['DB']->query("SELECT * FROM tags");
         $tag_array = array();
         foreach($return_tags as $tag)
         {
             $name = $tag['name'];
             $id = $tag['id'];
             $new_tag = new Tags($name,$id);
             array_push($tag_array, $new_tag);
         }
         return $tag_array;
     }

 }




 ?>
