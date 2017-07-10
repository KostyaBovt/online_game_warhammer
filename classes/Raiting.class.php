<?php
class Raiting {
    protected $_db;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

	static function doc() {
		$content = file_get_contents("docs/Raiting.doc.txt");
		echo $content;
		return;
	}

    public function get() {
        $this->_db->query('SELECT * FROM users WHERE wins > 0 ORDER BY wins DESC');
        return $this->_db->results();
    }
}
?>