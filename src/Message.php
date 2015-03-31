<?php



    class Message
    {
        private $message_id;
        private $message;
        private $user_id;
        private $date;

        function __construct($message, $date, $user_id,  $id = null)
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
            $statement = $GLOBALS['DB']->query("INSERT INTO messages (message, created) VALUES ('{$this->getMessage()}, {$this->getDate()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setMessageId($result['id']);

        }

        function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM messages *;");
        }

        function getAll()
        {
            $returned_messages = $GLOBALS['DB']->query("SELECT * FROM messages;");
            $messages = array();
            foreach($returned_messages as $message) {
                $message = $message['message'];
                $message_id = $message['id'];
                $date = $message['created'];
                $user_id = $message['user_id'];
                $new_message = new Message($message, $date, $user_id, $message_id);
                array_push($messages, $new_message);
            }
            return $messages;
        }

        static function find($search_id)
        {
            $found_message = null;
            $messages = Message::getAll();
            foreach($messages as $message) {
                $message_id = $message->getMessageId();
                if ($message_id == $search_id) {
                  $found_message = $message;
                }
            }
            return $found_message;
        }

        function update($new_message)
        {
            $GLOBALS['DB']->exec("UPDATE messages SET message = '{$new_message}' WHERE id = {$this->getMessageId()};");
            $this->setMessage($new_message);
        }

        function addTag($tag)
        {
            $GLOBALS['DB']->exec("INSERT INTO messages_tags (message_id, tag_id) VALUES
            ({$this->getMessageId()}, {$tag->getTagId()});");
        }

        function getTags()
        {
            $query = $GLOBALS['DB']->query("SELECT tags.* FROM messages JOIN messsages_tags ON (message.id = messages_tags.message_id)
             JOIN  tags ON (messages_tags.tag_id = tags.id) WHERE message.id = {$this->getMessageId()} ");
            $message_tags = $query->fetchAll(PDO::FETCH_ASSOC);
            $tags = array();
            foreach($message_tags as $message_tag) {
                $tag_id = $message_tag['id'];
                $tag_name = $message_tag['name'];
                $new_tag = new Tag($tag_name, $tag_id);
                array_push($tags, $new_tag);
            }
            return $tags;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM messages WHERE id = {$this->getMessageId()};");
            $GLOBALS['DB']->exec("DELETE FROM messages_tags WHERE message_id = {$this->getMessageId()};");
        }






    }



 ?>
