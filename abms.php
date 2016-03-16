<?php
/**
 * @Author: sahildua2305
 * @Date:   2016-03-10 01:05:47
 * @Last Modified by:   Sahil Dua
 * @Last Modified time: 2016-03-10 09:38:24
 */

/**
 * Main class absm for defining a particular A/B test
 */
class abms {
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


	/**
	 * __construct - Constructor for absm class
	 * @param string  $name     Test name
	 * @param int 	  $duration Test run duration
	 * @param boolean $adaptive Determines whether the user split will be adaptive or not
	 *                          Adaptive split means implementation of 90/10 split algorithm
	 */
	function __construct ($name, $duration, $adaptive = FALSE) {

		// detect if it's a bot
		if($this->detect_bots == TRUE) {
			$bots = array('googlebot', 'msnbot', 'slurp', 'ask jeeves', 'crawl', 'ia_archiver', 'lycos');
			foreach($bots as $botname) {
				if(stripos($_SERVER['HTTP_USER_AGENT'], $botname) !== FALSE) {
					$this->is_bot = TRUE;
					break;
				}
			}
		}

		$name = str_replace(' ', '_', $name);

		 $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        $this->connection = new PDO('mysql  :host=' .$this->mysql_host . ';dbname=' . $this->mysql_data,$this->mysql_user , $this->mysql_pass, $options);

        $sql = "SELECT * FROM test WHERE test_name='$name'";
		$query = $this->connection->prepare($sql);
		$query->execute();

		if($query->fetchColumn() == 0) {
			// This is the first time this test is run
			$curr_time = time();
			$this->test_start_timestamp = $curr_time;
			$sql="INSERT INTO test(test_name, ongoing, start_timestamp) VALUES('$name', 1, '$curr_time')";
			$query = $this->connection->prepare($sql);
			$query->execute();
			$sql="SELECT test_id FROM test WHERE test_name='$name'";
			$query = $this->connection->prepare($sql);
			$query->execute();
			$row = array();
			while(array_push($row, $query->fetch())){
				$this->test_id = $row['test_id'];
			}
		}
		else{
			// This test has been saved earlier as well
			$this->new_test = FALSE;
			$row = array();
			while(array_push($row, $query->fetch())){
				$this->test_start_timestamp = $row['start_timestamp'];
				$this->test_id = $row['test_id'];
			}
		}

		$this->test_name = $name;
		$this->test_duration = $duration;
		$this->adaptive = $adaptive;

		// Check if this test is over or not
		if($this->test_start_timestamp + $this->test_duration <= time())
			$this->test_over = TRUE;
	}


	/**
	 * add_variation - Public method for adding a new variation to a test case
	 * @param int 	$index 	variation index (0 stands for `A` and 1 stands for `B`)
	 * @param int 	$value 	variation value
	 */
	public function add_variation ($index, $value) {
		// add a new variation with given index and value to $this->variations
		$a = array(
			'index' => $index,
			'value' => $value,
		);
		array_push($this->variations, $a);

		// if this is variation for a new test, add the variation in `variation` table
		if($this->new_test)
			$sql="INSERT INTO variation(test_id, variation_index, show_count, success_count) VALUES('$this->test_id', '$index', 1, 1)";
			$query=$this->connection->prepare($sql);
			$query->execute();
	}


	/**
	 * get_user_segment - choose which of the segment among A and B
	 * will the current user be directed to
	 * 
	 */
	public function get_user_segment () {

		// If it's a bot visit, return -1 (control statement)
		if ($this->is_bot == TRUE) {
			$this->current_variation = -1;
			return $this->current_variation;
		}

		// If the current test is already over, return the automatic winner
		if($this->test_over){
			$winner = 0;
			$max_ratio = -1.0;
			$sql="SELECT * FROM variation WHERE test_id='$this->test_id'";
			$query = $this->connection->prepare($sql);
			$query->execute();
			$row = array();
			while(array_push($row, $query->fetch())){
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
			// implement that f*cking 90-10 logic
			$random= rand(0,100001);
			if($random<101){
				$this->current_variation = rand(1, 100000) % 2;
			}
			else{
				// find the ratios for two variations and return the one with greater ratio
				$sql="SELECT * FROM variation WHERE test_id='$this->test_id'";
				$query =$this->connection->prepare($sql);
				$query->execute();
				$winner = 0;
				$max_ratio = -1.0;
				$row = array();
				while(array_push($row, $query->fetch())){
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

		// Increment show_count for this chosen variation
		$sql="SELECT show_count FROM variation WHERE test_id='$this->test_id' AND variation_index='$this->current_variation'";
		$query = $this->connection->prepare($sql);
		$query->execute();
		$count = 0;
		$row = array();
		while(array_push($row, $query->fetch())){
			$count = $row['show_count'];
		}
		$count += 1;
		$sql="UPDATE variation SET show_count='$count' WHERE  test_id='$this->test_id' AND variation_index='$this->current_variation'";
		$query = $this->connection->prepare($sql);
		$query->execute();

		return $this->current_variation;
	}

	
	/**
	 * access_variations - Access variations for a particular test_id
	 * @param  int 	$index 	Test ID for which we have to access the variations
	 */
	public function access_variations ($index){
		return $this->variations[$index];
	}


	/**
	 * get_test_id - Get Test ID for the current instance of test
	 */
	public function get_test_id () {
		return $this->test_id;
	}


	/**
	 * is_test_over - Check if this test is already over
	 * @return boolean Returns TRUE if this test is already over
	 *                         and FALSE if it's not
	 */
	public function is_test_over () {
		return $this->test_over;
	}

}
