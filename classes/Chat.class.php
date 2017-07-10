<?php
    class Chat {
        protected $_db;

        public function __construct() {
            $this->_db = DB::getInstance();
        }

        static function doc() {
            $content = file_get_contents("docs/Chat.doc.txt");
            echo $content;
            return;
        }

        public function send($fields) {
            if (!$this->_db->insert('messages', $fields)) {
                throw new Exception("There was a problem.");
            }
        }
        
        public function get() {
            $this->_db->query('SELECT * FROM messages');
            return $this->_db->results();
        }
    }
?>