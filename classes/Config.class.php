<?php
	class Config {
		public static function get($name = null) {
			if($name) {
				$config = $GLOBALS['config'][$name];
				return $config;
			}
			return false;
		}

		static function doc() {
			$content = file_get_contents("docs/Config.doc.txt");
			echo $content;
			return;
		}
	}
?>