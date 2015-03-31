<?php

    class Message
    {
        <?php

    class Message
    {
        private $message_id;
        private $message;
        private $user_id;
        private $date;

        function __construct($user_id, $message, $date, $id = null)
        {
            $this->user_id = $user_id;
            $this->message = $message;
            $this->date = $date;
            $this->message_id = $id;
        }

        function getMessageId()
        {
            return $this->message_id;
        }

        function setMessageId($new_id)
        {
             $this->message_id = $new_id;
        }

        function getUserId()
        {
            return $this->user_id;
        }

        function setUserId($user_id)
        {
             $this->user_id;
        }

        function getMessage()
        {
            return $this->message;
        }

        function setMessage($new_message)
        {
            $this->message = $new_message;
        }

        function getDate()
        {
            return $this->date;
        }

        function setDate($new_date)
        {
             $this->date = $new_date;
        }

        function save()
        {

        }

        function deleteAll()
        {

        }

        function getAll()
        {

        }

        function find($message_id)
        {

        }

        function update($new_message)
        {

        }

        function addTag($tag)
        {

        }

        function getTags()
        {

        }

        function delete()
        {

        }






    }



 ?>
