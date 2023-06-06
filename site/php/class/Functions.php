<?php
class Functions {
	private static $instance = null;

	private function __construct() {

	}

    public static function getInstance()
	{
		if (self::$instance == null)
		{
			self::$instance = new Functions();
		}

		return self::$instance;
	}

	public static function callback_array_walk_trim(&$item_value, $item_key)
	{
	    if (is_array($item_value)){
            array_walk($item_value, 'Functions::callback_array_walk_trim');
        }
        else{
            $item_value = trim($item_value);
        }
	}
}