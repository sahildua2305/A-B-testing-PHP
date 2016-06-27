# A-B-testing-PHP

A light-weight and modular framework written in PHP that automates A/B testing

### Features:
 - Acts as an HTTP reverse proxy for any backend serving the traffic
 - Able to split the incoming traffic
 - Tracks the goal
 - Automatically declares a winner at the end of the mentioned time frame
 - Able to switch to the segment that wins statistically at the end of the experiment
 - Adaptive algorithm to favor the winning segment
 - Uses PDO for database connection

### Usage:
 - Clone the repo on your local machine
 - Include the `abms.php` in your code
 - Instantiate a new object of `abms` with desired parameters
 - Define different variations of the desired element on your page
 - Find the segment for any user before rendering HTML for that user using method `get_user_segment()`
 - And start tracking your events!
