<?php
	class Redirect {
		public static function to($location = null) {
			if ($location) {
				header('Location: '. $location);
				exit();
			}
		}

		static function doc() {
			$content = file_get_contents("docs/Redirect.doc.txt");
			echo $content;
			return;
		}
	}
?>