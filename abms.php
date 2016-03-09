<?php
/**
 * @Author: sahildua2305
 * @Date:   2016-03-10 01:05:47
 * @Last Modified by:   Sahil Dua
 * @Last Modified time: 2016-03-10 01:55:48
 */


class abms
{
	private $test_name;
	private $is_bot = FALSE;
	private $test_duration;
	private $test_start_timestamp;
	private $variations = array();
	private $adaptive = FALSE;
	

	function __construct ($name, $duration, $adaptive = FALSE) {

		if($this->detect_bots == TRUE){
			$bots = array('googlebot', 'msnbot', 'slurp', 'ask jeeves', 'crawl', 'ia_archiver', 'lycos');
			foreach($bots as $botname)
			{
				if(stripos($_SERVER['HTTP_USER_AGENT'], $botname) !== FALSE)
				{
					$this->is_bot = TRUE;
					break;
				}
			}
		}

		$name = str_replace(' ', '_', $name);
		$this->test_name = $name;
		$this->test_duration = $duration;
		$this->adaptive = $adaptive;
	}


	public function add_variation ($index, $value){
		// add a new variation with given index and value to $this->variations
		$a = array(
			'index' => $index,
			'value' => $value,
		);
		array_push($this->variations, $a);
	}

}
