<?php
class Npl_Dump {
	public static function Nice($mixed) {
		echo "<pre>";
		var_dump($mixed);
		echo "</pre>";
	}
	
	public static function Raw($mixed) {
		var_dump($mixed);
	}
	
	public static function Html($mixed) {
		echo "<pre style=\"border: 1px solid #000; overflow: auto; margin: 0.5em;\">";
		var_dump($mixed);
		echo "</pre>\n";
	}
}