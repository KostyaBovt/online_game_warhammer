<?php
	class Lobby {
		protected $_db;

		public function __construct() {
			$this->_db = DB::getInstance();
		}
		
		static function doc() {
			$content = file_get_contents("docs/Lobby.doc.txt");
			echo $content;
			return;
		}

		public function getActiveGameId($user_id) {
			$this->_db->query('SELECT * from `games` WHERE (`user_1` = ' . $user_id .' OR `user_2` = ' . $user_id . ') AND `finished` = 0');
			if ($this->_db->count()) {			
				return $this->_db->results()[0]->id;
			} else {
				return 0;
			}
		}

		public function getOpenGames() {
			$this->_db->query('SELECT * from `games` WHERE `user_2` = 0 AND `finished` = 0');
			$open_games = $this->_db->results();
			//print_r($open_games); 
			return $open_games;
		}


	}
?>