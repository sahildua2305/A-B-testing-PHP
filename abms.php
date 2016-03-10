<?php
/**
 * @Author: sahildua2305
 * @Date:   2016-03-10 01:05:47
 * @Last Modified by:   Sahil Dua
 * @Last Modified time: 2016-03-10 03:49:18
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
	private $connection;
	private $connect_error = 'Could not connect';
	private $mysql_host = 'localhost';
	private $mysql_user = 'root';
	private $mysql_pass = '';
	private $mysql_data = 'ab_testing';
	private $test_id;
	private $new_test = TRUE;
	private $test_over = FALSE;


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

		$this->connection = mysqli_connect($this->mysql_host , $this->mysql_user , $this->mysql_pass, $this->mysql_data);
		if(!($this->connection)){
			die(mysqli_error($this->connection));
		}

		$query = mysqli_query($this->connection, "SELECT * FROM test WHERE test_name='$name'") or die("error");
		if(mysqli_num_rows($query) == 0) {
			$curr_time = time();
			$this->test_start_timestamp = $curr_time;
			mysqli_query($this->connection, "INSERT INTO test(test_name, ongoing, start_timestamp) VALUES('$name', 1, '$curr_time')") or die("errorrr");
			$query = mysqli_query($this->connection, "SELECT test_id FROM test WHERE test_name='$name'");
			while($row = mysqli_fetch_array($query)){
				$this->test_id = $row['test_id'];
			}
		}
		else{
			$this->new_test = FALSE;
			while($row = mysqli_fetch_array($query)){
				$this->test_start_timestamp = $row['start_timestamp'];
				$this->test_id = $row['test_id'];
			}
		}

		$this->test_name = $name;
		$this->test_duration = $duration;
		$this->adaptive = $adaptive;

		if($this->test_start_timestamp + $this->test_duration <= time())
			$this->test_over = TRUE;
	}


	public function add_variation ($index, $value) {
		// add a new variation with given index and value to $this->variations
		$a = array(
			'index' => $index,
			'value' => $value,
		);
		array_push($this->variations, $a);

		if($this->new_test)
			mysqli_query($this->connection, "INSERT INTO variation(test_id, variation_index, show_count, success_count) VALUES('$this->test_id', '$index', 0, 0)") or die("error in an inserting variation");
	}


	public function get_user_segment () {
		if ($this->is_bot == TRUE) {
			$this->current_variation = -1;
			return $this->current_variation;
		}

		if($this->test_over){
			$winner = 0;
			$max_ratio = -1.0;
			$query = mysqli_query($this->connection, "SELECT * FROM variation WHERE test_id='$this->test_id'");
			while($row = mysqli_fetch_array($query)){
				if($row['show_count'] != 0)
					$ratio = $row['success_count'] / $row['show_count'];
				else
					$ratio = 0;
				if($ratio > $max_ratio){
					$max_ratio = $ratio;
					$winner = $row['variation_index'];
				}
			}

			return $winner;
		}

		// check for which algorithm we're going to use for splitting the user traffic
		if($this->adaptive == TRUE) {
			// implement that fucking 90-10 logic
			$random= rand(0,100001);
			if($random<101){
				$this->current_variation = rand(1, 100000) % 2;
			}
			else{
				// find the ratios for two variations and return the one with greater ratio
				$query = mysqli_query($this->connection, "SELECT * FROM variation WHERE test_id='$this->test_id'") or die("error in getting");
				$winner = 0;
				$max_ratio = -1.0;
				while($row = mysqli_fetch_array($query)){
					if($row['show_count'] != 0)
						$ratio = $row['success_count'] / $row['show_count'];
					else
						$ratio = 0;
					if($ratio > $max_ratio){
						$max_ratio = $ratio;
						$winner = $row['variation_index'];
					}
				}
				$this->current_variation = $winner;
			}
		}
		else {
			// implement 50-50 logic (random)
			$this->current_variation = rand(1, 100000) % 2;
		}

		$query = mysqli_query($this->connection, "SELECT show_count FROM variation WHERE test_id='$this->test_id' AND variation_index='$this->current_variation'") or die("error in getting");
		$count = 0;
		while($row = mysqli_fetch_array($query)){
			$count = $row['show_count'];
		}
		$count += 1;
		mysqli_query($this->connection, "UPDATE variation SET show_count='$count' WHERE  test_id='$this->test_id' AND variation_index='$this->current_variation'") or die("error in updating");

		return $this->current_variation;
	}

	
	public function access_variations ($index){
		return $this->variations[$index];
	}


	public function get_test_id () {
		return $this->test_id;
	}


	public function is_test_over () {
		return $this->test_over;
	}

}
