<?php

    class Message
    {
        private $id;
        private $text;
        private $user_id;

        function __construct($user_id, $text, $id = null)
        {
            $this->user_id = $user_id;
            $this->text = $text;
            $this->id = $id;
        }

        function getId() {
            return $this->id;
        }





    }



 ?>
