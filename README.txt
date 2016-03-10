INSTALLATION 
------------

INSTALLER
.........

1) Extract the product archive in web root. e.g. www/chartphp
2) Open it in browser to run installer. e.g. http://localhost/chartphp

INTEGRATION
-----------
- For integration in your app, you might need to consider 2 things.

1) The folder "../../lib" will be replaced by path where you place 'lib' folder (if changed)

	<script src="../../lib/js/jquery.min.js"></script>
	<script src="../../lib/js/chartphp.js"></script>
	<link rel="stylesheet" href="../../lib/js/chartphp.css">

2) Update include path where you place lib/inc/jqgrid_dist.php. (if changed)

	include("../../lib/inc/chartphp_dist.php");
	$p = new chartphp();

Refer 'Getting Started' section on http://www.chartphp.com/docs for more details.

Refer 'FAQs' on http://www.chartphp.com/faqs for common questions and issues.

UPGRADE
-------
To upgrade, just override "lib/inc" & "lib/js" folder in previous implementations. For technical support queries, suggestions and wishlist, you can contact at our Support Center (http://www.phpgrid.org/support)

UPDATES
-------
Visit http://www.chartphp.com/blog for updates and changelog.

FEEDBACK
--------
Post bugs/wishlist at http://www.chartphp.com/contact

LICENSE
-------
Must read and agree LICENSE.txt before use.
