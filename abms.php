<?php
/**
 * @Author: sahildua2305
 * @Date:   2016-03-10 01:05:47
 * @Last Modified by:   Sahil Dua
 * @Last Modified time: 2016-03-10 02:37:29
 */


class abms
{
	private $test_name;
	private $is_bot = FALSE;
	private $test_duration;
	private $test_start_timestamp;
	private $variations = array();
	private $adaptive = FALSE;
	private $current_variation;
	private $detect_bots = TRUE;
	

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


	public function add_variation ($index, $value) {
		// add a new variation with given index and value to $this->variations
		$a = array(
			'index' => $index,
			'value' => $value,
		);
		array_push($this->variations, $a);
	}


	public function get_user_segment () {
		if ($this->is_bot == TRUE) {
			$this->current_variation = -1;
			return $this->current_variation;
		}

		// check for which algorithm we're going to use for splitting the user traffic
		if($this->adaptive == TRUE) {
			// implement that fucking 90-10 logic
			$random= rand(0,100001);
			if($random<101){
				$this->current_variation = rand(1, 100000) % 2;
			}
			else{

			}
		}
		else {
			// implement 50-50 logic (random)
			$this->current_variation = rand(1, 100000) % 2;
		}

		return $current_variation;
	}

	public function access_variations ($index){
		return $this->variations[$index];
	}



}
