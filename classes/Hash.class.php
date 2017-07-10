<?php
	class Hash {

		static function doc() {
			$content = file_get_contents("docs/Hash.doc.txt");
			echo $content;
			return;
		}

		public static function make($string, $salt = '') {
			return hash('sha256', $string . $salt);
		}

		public static function salt($length) {
			return openssl_random_pseudo_bytes($length);
		}

		public static function unique() {
			return self::make(uniqid());
		}
	}
?>