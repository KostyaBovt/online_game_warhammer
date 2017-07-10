<?php
	class Game {
		protected $_id;
		protected $_user_1;
		protected $_user_2;
		protected $_winner;
		protected $_finished;
		protected $_game_status;
		protected $_db;

		public function __construct() {
			$this->_db = DB::getInstance();
		}

		static function doc() {
			$content = file_get_contents("docs/Game.doc.txt");
			echo $content;
			return;
		}

		public function __toString() {
			return '<br/> id:' .  $this->_id .
			'<br/> user_1:' .  $this->_user_1 .
			'<br/> user_2:' .  $this->_user_2 .
			'<br/> winner:' .  $this->_winner .
			'<br/> finished:' .  $this->_finished;
		} 

		public function create() {
			$user_1 = array(
				'health' => 15,
				'speed' => 10,
				'power' => 5,
				'x' => 3,
				'y' => 98,
				'direction' => 1
			);

			$user_2 = array(
				'health' => 15,
				'speed' => 10,
				'power' => 5,
				'x' => 148,
				'y' => 3,
				'direction' => 3
			);

			$this->_db->insert('games', array(
				'user_1' => 0,
				'user_2' => 0,
				'winner' => 0,
				'finished' => 0,
				'game_status' => json_encode(array(
					'user_1' => $user_1,
					'user_2' => $user_2,
					'turn' => 1,
					'phase' => 1
				))
			));
			$this->_id = $this->_db->getLastId();
		}

		public function getData($id) {
			$this->_db->get('games', array('id', '=', $id));
			$data = $this->_db->results()[0]; 
			$this->_id = $data->id;
			$this->_user_1 = $data->user_1;
			$this->_user_2 = $data->user_2;
			$this->_winner = $data->winner;
			$this->_finished = $data->finished;
			$this->_game_status = json_decode($data->game_status);
		}

		public function uploadData($id) {
			$this->_db->update('games', $id, array(
				'user_1' => $this->_user_1,
				'user_2' => $this->_user_2,
				'winner' => $this->_winner,
				'finished' => $this->_finished,
				'game_status' => json_encode($this->_game_status)
			));
		}

		public function addPlayer1($id) {
			Session::put('active_game', $this->_id);
			$this->_user_1 = $id;
			$this->_db->update('games', $this->_id, array(
				'user_1' => $id
			));
		}

		public function addPlayer2($id) {
			Session::put('active_game', $this->_id);
			$this->_user_2 = $id;
			$this->_db->update('games', $this->_id, array(
				'user_2' => $id
			));
		}

		public function getAtt($name) {
			return $this->{'_' . $name};
		}

		public function getShipCords($user) {
			$ship = array(
				$this->_game_status->{'user_' . $user}->x,
				$this->_game_status->{'user_' . $user}->y,
				$this->_game_status->{'user_' . $user}->direction,
			);

			$return = array();

				$return[] = $ship[0] + ($ship[1] - 1) * 150;
				if ($ship[2] == 1 || $ship[2] == 3) {
					$return[] = $ship[0] + ($ship[1] - 1 + 1) * 150;
					$return[] = $ship[0] + ($ship[1] - 1 + 2) * 150;
					$return[] = $ship[0] + ($ship[1] - 1 - 1) * 150;
					$return[] = $ship[0] + ($ship[1] - 1 - 2) * 150;
				}
				if ($ship[2] == 2 || $ship[2] == 4) {
					$return[] = $ship[0] + 1 + ($ship[1] - 1) * 150;
					$return[] = $ship[0] + 2 + ($ship[1] - 1) * 150;
					$return[] = $ship[0] - 1 + ($ship[1] - 1) * 150;
					$return[] = $ship[0] - 2 + ($ship[1] - 1) * 150;
				}

			return $return;
		}

		public function validateAction($action) {
			if ($this->_winner != 0) {
				return false;
			}

			$turn = $this->_game_status->turn;
			$curr_user_turn = $this->{'_user_'. $turn};
			if (Session::get('logged_user') != $curr_user_turn) {
				return false;
			};

			$phase = $this->_game_status->phase;
			if ($action == 'move' && $phase == 3) {
				return false;
			}
			if (($action == 'rotateLeft' || $action == 'rotateRight') && $phase > 1) {
				return false;
			}
			return true;
		}

		public function executeAction($action, $argument) {
			$this->{$action}($argument);
			print_r($this->_game_status);
			if (!$this->uploadData($this->_id)) {
				echo 'error updatin';
			}
		}

		public function rotateLeft($argument) {
			$turn = $this->_game_status->turn;
			$curr_direction = $this->_game_status->{'user_' . $turn}->direction;
			$new_direction = ($curr_direction == 1) ? 4 : $curr_direction - 1;
			$this->_game_status->{'user_' . $turn}->direction = $new_direction;

			$this->_game_status->phase = 2;
		}

		public function rotateRight($argument) {
			$turn = $this->_game_status->turn;
			$curr_direction = $this->_game_status->{'user_' . $turn}->direction;
			$new_direction = ($curr_direction == 4) ? 1 : $curr_direction + 1;
			$this->_game_status->{'user_' . $turn}->direction = $new_direction;

			$this->_game_status->phase = 2;
		}

		public function move($speed) {
			if ($speed > 30 || $speed < 1) {
				return;
			}
			$turn = $this->_game_status->turn;
			$curr_direction = $this->_game_status->{'user_' . $turn}->direction;
			$curr_x = $this->_game_status->{'user_' . $turn}->x;
			$curr_y = $this->_game_status->{'user_' . $turn}->y;
			if ($curr_direction == 1) {
				$new_y = $curr_y - $speed;
				if ($new_y > 2) {
					$this->_game_status->{'user_' . $turn}->y = $new_y;
				} else {
					return;
				}
			}
			if ($curr_direction == 2) {
				$new_x = $curr_x + $speed;
				if ($new_x < 149) {
					$this->_game_status->{'user_' . $turn}->x = $new_x;
				} else {
					return;
				}
			}
			if ($curr_direction == 3) {
				$new_y = $curr_y + $speed;
				if ($new_y < 99) {
					$this->_game_status->{'user_' . $turn}->y = $new_y;
				} else {
					return;
				}
			}
			if ($curr_direction == 4) {
				$new_x = $curr_x - $speed;
				if ($new_x > 2) {
					$this->_game_status->{'user_' . $turn}->x = $new_x;
				} else {
					return;
				}
			}

			$this->_game_status->phase = 3;
		}

		public function shoot() {
			$turn = $this->_game_status->turn;
			$not_turn = $turn == 1 ? 2 : 1;
			$ship_active = $this->getShipCords($turn);
			$ship_passiv = $this->getShipCords($not_turn);

			print_r($ship_passiv);

			$fire_pos_x = $this->_game_status->{'user_' . $turn}->x;
			$fire_pos_y = $this->_game_status->{'user_' . $turn}->y;
			$fire_direct = $this->_game_status->{'user_' . $turn}->direction;
			$fire_path = array();
			
			if ($fire_direct == 1) {
				$fire_pos_y -= 3;
				$fire_pos = ($fire_pos_y - 1) * 150 + $fire_pos_x;
				$fire_path_len = min(30, $fire_pos_y);
				for($i = 0; $i <= $fire_path_len; $i++) {
					$fire_path[] = $fire_pos - $i * 150;
				}
			}

			if ($fire_direct == 3) {
				$fire_pos_y += 3;
				$fire_pos = ($fire_pos_y - 1) * 150 + $fire_pos_x;
				$fire_path_len = min(30, 100 - $fire_pos_y);
				for($i = 0; $i <= $fire_path_len; $i++) {
					$fire_path[] = $fire_pos + $i * 150;
				}
			}

			if ($fire_direct == 2) {
				$fire_pos_x += 3;
				$fire_pos = ($fire_pos_y - 1) * 150 + $fire_pos_x;
				$fire_path_len = min(30, 150 - $fire_pos_x);
				for($i = 0; $i <= $fire_path_len; $i++) {
					$fire_path[] = $fire_pos + $i;
				}
			}

			if ($fire_direct == 4) {
				$fire_pos_x -= 3;
				$fire_pos = ($fire_pos_y - 1) * 150 + $fire_pos_x;
				$fire_path_len = min(30, $fire_pos_x);
				for($i = 0; $i <= $fire_path_len; $i++) {
					$fire_path[] = $fire_pos - $i;
				}
			}

			$intersect = array_intersect($ship_passiv, $fire_path);
			if (count($intersect)) {
				$this->_game_status->{'user_' . $not_turn}->health -= 5;
			}

			$this->_game_status->phase = 1;
			$this->_game_status->turn = $not_turn;

		}


		public function checkWinner() {
			if ($this->_winner == 0) {
				$health1 = $this->_game_status->user_1->health;	
				$health2 = $this->_game_status->user_2->health;

				if ($health1 <= 0 || $health2 <= 0) {
					$this->_winner = ($health1 <= 0) ? $this->_user_2 : $this->_user_1;
					$this->uploadData($this->_id);

					$win_user = new User($this->_winner);
					$new_wins = $win_user->data()->wins + 1;
					$win_user->update(array('wins' => $new_wins), $this->_winner);
				}
			}
		}

		public function finishGame() {
			if ($this->_winner == 0) {
				$loser_user = Session::get('logged_user');
				if ($this->_user_1 == $loser_user) {
					$this->_winner = $this->_user_2;
				} else if ($this->_user_2 == $loser_user) {
					$this->_winner = $this->_user_1;
				}
				$win_user = new User($this->_winner);
				$new_wins = $win_user->data()->wins + 1;
				$win_user->update(array('wins' => $new_wins), $this->_winner);
			}
			$this->_finished = 1;
			$this->uploadData($this->_id);

			Session::delete('active_game');
		}

	}
?>