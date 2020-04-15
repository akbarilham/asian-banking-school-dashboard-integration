<?php
require_once("../And_config.php") ;

	$con = mysqli_connect($mysqlHostName,$mysqlUserName,$mysqlPassword,$mysqlDatabaseName);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	}

	//ENTER THE RELEVANT INFO BELOW
	$mysqlDatabaseName = $CFG->dbname;
	$mysqlUserName = $CFG->dbuser;
	$mysqlPassword = $CFG->dbpass;
	$mysqlHostName = $CFG->dbhost;
	$mysqlExportPath = "dboffline.sql";
	$mysqlQuery = "select u.firstname, c.fullname as coursename, ss.identifier, ss.title, s.name as scormname, sst.attempt, sst.element, sst.value
	from mdl_user u, mdl_course c, mdl_scorm_scoes_track sst, mdl_scorm s, mdl_scorm_scoes ss, mdl_context ctx, mdl_role_assignments ra
	where sst.userid = u.id
	and sst.scormid = s.id
	and sst.scoid = ss.id
	and s.course = c.id
	and ss.scorm = s.id
	and ra.contextid = ctx.id
	AND ra.userid = u.id
	AND ctx.contextlevel = 50
	AND ctx.instanceid = c.id";
	
	$backup_file = $mysqlDatabaseName . date("Y-m-d-H-i-s") . '.gz';
	//$command = "mysqldump --opt -h $mysqlHostName -u $mysqlUserName -p $mysqlPassword ".
		//	   "test_db | gzip > $backup_file";

	system('cmd /c C:\xampp\mysql\bin\dbmoodleoffline.bat');

	/*
	//Export the database and output the status to the page
	$command='mysqldump -e '.$mysqlQuery.' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ~/' .$mysqlExportPath;
	exec($command);
	
	$export = mysqli_query ($mysqlQuery, $con);
	$fields = mysqli_num_fields ( $export );
	for ( $i = 0; $i < $fields; $i++ )
	{
		$header .= mysqli_field_name( $export , $i ) . "\t";
	}

	while( $row = mysqli_fetch_row( $export ) )
	{
		$line = '';
		foreach( $row as $value )
		{                                            
			if ( ( !isset( $value ) ) || ( $value == "" ) )
			{
				$value = "\t";
			}
			else
			{
				$value = str_replace( '"' , '""' , $value );
				$value = '"' . $value . '"' . "\t";
			}
			$line .= $value;
		}
		$data .= trim( $line ) . "\n";
	}
	$data = str_replace( "\r" , "" , $data );

	if ( $data == "" )
	{
		$data = "\n(0) Records Found!\n";                        
	}

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=moodleoffline.sql");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$data";
	*/

	function file_rewrite_pluginfile_urls($text, $file, $contextid, $component, $filearea, $itemid, array $options=null) {
	$CFG = new stdClass();
			$options = (array)$options;
			if (!isset($options['forcehttps'])) {
					$options['forcehttps'] = false;
			}
			$baseurl = "$CFG->wwwroot/pluginfile.php/$contextid/$component/$filearea/";

			if ($itemid !== null) {
					$baseurl .= "$itemid/";
			}

			if ($options['forcehttps']) {
					$baseurl = str_replace('http://', 'https://', $baseurl);
			}

	   return str_replace('@@PLUGINFILE@@/', $baseurl, $text);
	}

?>
