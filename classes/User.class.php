   <?php
	class User {
		private $_db;
		private $_data;
		private $_isLoggedIn;


		public function __construct($user = null) {
			$this->_db = DB::getInstance();

			if (!$user) {
				if(Session::exists('logged_user')) {
					$user = Session::get('logged_user');

					if ($this->find($user)) {
						$this->_isLoggedIn = true;
					} else {
						//log out user
					}
				}
			} else {
				$this->find($user);
			}
		}

		static function doc() {
			$content = file_get_contents("docs/User.doc.txt");
			echo $content;
			return;
		}

		public function update($fields = array(), $id = null) {

			if (!$id && $this->isLoggedIn()) {
				$id = $this->data()->id;
			}

			if (!$this->_db->update('users', $id, $fields)) {
				throw new Exception('There was a problem updating.');
			}
		}


		public function create($fields) {
			if (!$this->_db->insert('users', $fields)) {
				throw new Exception("There was a problem creating an account.");
			}
		}

		public function find($user = null) {
			if ($user) {
				$field = (is_numeric($user)) ? 'id' : 'login';
				$data = $this->_db->get('users', array($field, '=', $user));

				if ($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}

		public function login($username = null, $password = null) {
			
			if (!$username && !$password && $this->exists()) {
				Session::put('logged_user', $this->data()->id);
			} else {
				$user = $this->find($username);
				if ($user) {
					if ($this->data()->password === Hash::make($password)) {
						Session::put('logged_user', $this->data()->id);
						return true;
					}
				}
			}
			return false;
		}


		public function exists() {
			return (!empty($this->_data)) ? true : false;
		}


		public function logout() {
			Session::delete('logged_user');
		}

		public function data() {
			return $this->_data;
		}

		public function isLoggedIn() {
			return $this->_isLoggedIn;
		}
	}
?>