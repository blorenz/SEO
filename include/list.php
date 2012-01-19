<?php
 $PHP_SELF = $_SERVER['PHP_SELF'];
define('LIMIT', 20);

//JJM Added this check.  Seems as though it isn't always set,
//and who knows where it is coming from, but if it is not set, blank should work well
if(!isset($search_query))
	$search_query = "";

$result = db_do($sql, $search_query);
list($num_records) = db_row($result);

if (isset($limit) && $limit == -1) {
	$_GET['p']         = 0;
	$_start    = 0;
	$nav_links = "<font class=\"normal\"><a href=\"$PHP_SELF";

	if (!empty($s))
		$nav_links .= "?s=$s";

	if (!empty($sort))
				$nav_links .= "&sort=$sort";

	if (!empty($dir))
				$nav_links .= "&dir=$dir";

	if (!empty($id))
				$nav_links .= "&id=$id";

	if (!empty($did))
				$nav_links .= "&did=$did";

	if (!empty($ae_id))
				$nav_links .= "&ae_id=$ae_id";

	if (!empty($dm_id))
				$nav_links .= "&dm_id=$dm_id";

	if (!empty($_udr))
				$nav_links .= "&search_query_udr=$search_query_udr";

	$nav_links .= "\">show " . LIMIT . " per page</a></font>";
} else {
	if (empty($_GET['p']))
		$_GET['p'] = 0;

	$limit = LIMIT; # number of entries to display per page

	#
	# Check the bounds of the page to display and adjust if necessary.
	#

	if ($_GET['p'] < 0 || ($_GET['p'] * $limit) > $num_records)
	        $_GET['p'] = 0;

	#
	# Determine the limits for the entries to be displayed.
	#

	$start = ($_GET['p'] * $limit) + 1;
	$_start = $start - 1;
	$end = $_start + $limit;

	if ($end >= $num_records && $_GET['p'] == 0) {
		$end = $num_records;
		$limit = 500;
		$nav_links = '&nbsp;';
	} else {
		#
		# Determine if we need previous or next links or both.
		#

		$nav_links = '<table border="0" cellpadding="0" ' .
		    'cellspacing="0"><tr><td class="normal">Result page:' .
		    '&nbsp;&nbsp;</td>';

		if ($start > $limit) {
			$foo = $_GET['p'] - 1;
		        $nav_links .= '<td class="small"><a href="' .
			    $PHP_SELF . '?p=' . $foo;

			if (!empty($s))
				$nav_links .= "&s=$s";

			if (!empty($sort))
				$nav_links .= "&sort=$sort";

			if (!empty($dir))
				$nav_links .= "&dir=$dir";

			if (!empty($did))
				$nav_links .= "&did=$did";

			if (!empty($id))
				$nav_links .= "&id=$id";

			if (!empty($ae_id))
				$nav_links .= "&ae_id=$ae_id";

			if (!empty($dm_id))
				$nav_links .= "&dm_id=$dm_id";

			if (!empty($search_query_udr))
				$nav_links .= "&search_query_udr=$search_query_udr";

			$nav_links .= '">Previous</a>&nbsp;</td>';
		}

		#
		# Determine here and there.
		#

		$here = $_GET['p'] - 7;
		if ($here < 0)
			$here = 0;

		$there = $here + 15;
		if (($there * LIMIT) >= $num_records) {
			$there = floor($num_records / LIMIT);
			if ($num_records % LIMIT)
				$there++;
			$here = $there - 15;
			if ($here < 0)
				$here = 0;
		}

		for ($i = $here; $i < $there; $i++) {
			$foo = $i + 1;
			if ($i == $_GET['p'])
				$nav_links .= '<td class="normal">&nbsp;<b>' .
				    $foo . '&nbsp;</b></td>';
			else {
				$nav_links .= '<td class="normal">&nbsp;' .
				    '<a href="' . $PHP_SELF . '?p=' . $i;

				if (!empty($s))
					$nav_links .= "&s=$s";

				if (!empty($sort))
					$nav_links .= "&sort=$sort";

				if (!empty($dir))
					$nav_links .= "&dir=$dir";

				if (!empty($id))
					$nav_links .= "&id=$id";

				if (!empty($did))
					$nav_links .= "&did=$did";

				if (!empty($ae_id))
					$nav_links .= "&ae_id=$ae_id";

				if (!empty($dm_id))
					$nav_links .= "&dm_id=$dm_id";

				if (!empty($search_query_udr))
				$nav_links .= "&search_query_udr=$search_query_udr";

				$nav_links .= '">' . $foo . '</a>&nbsp;</td>';
			}
		}

		if ($end < $num_records) {
		        $foo = $_GET['p'] + 1;
		        $nav_links .= '<td class="small">&nbsp;<a href="' .
			    $PHP_SELF . '?p=' . $foo;

			if (!empty($s))
				$nav_links .= "&s=$s";

			if (!empty($sort))
				$nav_links .= "&sort=$sort";

			if (!empty($dir))
				$nav_links .= "&dir=$dir";

			if (!empty($id))
				$nav_links .= "&id=$id";

			if (!empty($did))
				$nav_links .= "&did=$did";

			if (!empty($ae_id))
				$nav_links .= "&ae_id=$ae_id";

			if (!empty($search_query_udr))
				$nav_links .= "&search_query_udr=$search_query_udr";

			if (!empty($dm_id))
				$nav_links .= "&dm_id=$dm_id";

			$nav_links .= '">Next</a></td>';
		}

		$nav_links .= "</tr></table>\n";
	}
}
?>
