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

 }




 ?>
