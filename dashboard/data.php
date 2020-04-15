<?php

	//--------Database-----------//
	$con = mysqli_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	if (!$con) {
	die('Could not connect: ' . mysql_error());
	}

	//mysql_select_db("moodle", $con);

	//role user
	$que =  "SELECT
                USER.firstname AS FN,
                course.fullname AS CS,
                course.id AS CSid,
                course.summary AS Sum,
                asg.contextid AS contextid,
                    (SELECT shortname FROM mdl_role WHERE id=asg.roleid)AS SN,
                uid.data                    
                FROM
                mdl_user AS USER,
                mdl_course AS course,
                mdl_user_info_data AS uid,
                mdl_role_assignments AS asg
                INNER JOIN mdl_context AS context ON asg.contextid=context.id 
                WHERE
                context.contextlevel = 50
                AND
                USER.id=asg.userid
                AND
                context.instanceid=course.id
                AND 
                uid.userid = USER.id";
	// role user v.1
	$quee = "SELECT u.id, u.firstname, u.lastname, uid.userid, uid.data, timecreated AS membersince
                FROM mdl_user u, mdl_user_info_data uid, mdl_user_info_field uif, mdl_user_info_category uic
                WHERE u.id = uid.userid
                AND uid.fieldid = uif.id
                AND uic.id = uif.categoryid";
	// Course Enroll Student List 
	$questudent2 = "SELECT * 
					FROM (SELECT u.id AS ke3, c.id, ctx.id AS Cid, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
						IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
						FROM mdl_log log
						WHERE log.course=c.id
						AND log.userid=u.id), 'Never') AS 'First Access',

						IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
						FROM mdl_user_lastaccess la
						WHERE la.userid=u.id
						AND la.courseid=c.id),'Never') AS 'Last Access'

						FROM mdl_user u
						JOIN mdl_user_enrolments ue ON ue.userid=u.id
						JOIN mdl_enrol e ON e.id=ue.enrolid
						JOIN mdl_course c ON c.id = e.courseid
						JOIN mdl_context AS ctx ON ctx.instanceid = c.id
						JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
						JOIN mdl_role AS r ON r.id = e.roleid

						WHERE ra.userid=u.id
						AND ctx.instanceid=c.id
						AND ra.roleid='5' 
						OR ra.roleid='3'
						AND c.visible='1'
							/*AND ValueCompleted LIKE '%100%'*/
							AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
							FROM mdl_grade_grades AS gg 
							JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
							WHERE gi.courseid=c.id
							AND gg.userid=u.id
							AND gi.itemtype='mod'
							GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
							FROM mdl_grade_items AS gi 
							WHERE gi.courseid = c.id
							AND gi.itemtype='mod'), '0'))*100,0), '0')) != '100' 				
						GROUP BY u.id, c.id
						ORDER BY u.lastname, u.firstname, c.fullname) AS T1 

					JOIN ( SELECT c.id, a.contextid AS Cid, a.component, a.filearea, a.itemid, a.filepath, a.filename, a.userid, a.mimetype 
						FROM mdl_files a, mdl_context b, mdl_course c 
						WHERE a.mimetype LIKE 'image%' 
						AND a.component = 'course'
						AND a.contextid = b.id ) AS T2 

					ON T1.id = T2.id
					AND T1.Cid = T2.Cid
					AND T2.filearea = 'summary'
                                        ORDER BY T1.ke3 ASC, T1.Cid ASC";
	// Course Enroll Student List SUM
	$questudent2s = "SELECT * 
					FROM (SELECT u.id AS ke3, c.id, ctx.id AS Cid, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
						IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
						FROM mdl_log log
						WHERE log.course=c.id
						AND log.userid=u.id), 'Never') AS 'First Access',

						IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
						FROM mdl_user_lastaccess la
						WHERE la.userid=u.id
						AND la.courseid=c.id),'Never') AS 'Last Access',
						  
						  (SELECT COUNT(u.id)) AS 'JumlahBero'
						
						FROM mdl_user u
						JOIN mdl_user_enrolments ue ON ue.userid=u.id
						JOIN mdl_enrol e ON e.id=ue.enrolid
						JOIN mdl_course c ON c.id = e.courseid
						JOIN mdl_context AS ctx ON ctx.instanceid = c.id
						JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
						JOIN mdl_role AS r ON r.id = e.roleid

						WHERE ra.userid=u.id
						AND ctx.instanceid=c.id
						AND ra.roleid='5' 
			
						AND c.visible='1'
								/*AND ValueCompleted LIKE '%100%'*/
								AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
								FROM mdl_grade_grades AS gg 
								JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
								WHERE gi.courseid=c.id
								AND gg.userid=u.id
								AND gi.itemtype='mod'
								GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
								FROM mdl_grade_items AS gi 
								WHERE gi.courseid = c.id
								AND gi.itemtype='mod'), '0'))*100,0), '0')) != '100' 				
						GROUP BY u.id
						ORDER BY u.lastname, u.firstname, c.fullname) 
					AS T1 

					JOIN ( SELECT c.id, a.contextid AS Cid, a.component, a.filearea, a.itemid, a.filepath, a.filename, a.userid, a.mimetype 
						  FROM mdl_files a, mdl_context b, mdl_course c 
						  WHERE a.mimetype LIKE 'image%' 
						  AND a.component = 'course'
						  AND a.contextid = b.id ) 
					AS T2 

					ON T1.id = T2.id
					AND T1.Cid = T2.Cid";
	// Course Enroll Teacher List 
	$queteacher2 = "SELECT * 
					FROM (SELECT u.id AS ke3, c.id, ctx.id AS Cid, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
						IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
						FROM mdl_log log
						WHERE log.course=c.id
						AND log.userid=u.id), 'Never') AS 'First Access',

						IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
						FROM mdl_user_lastaccess la
						WHERE la.userid=u.id
						AND la.courseid=c.id),'Never') AS 'Last Access'

						FROM mdl_user u
						JOIN mdl_user_enrolments ue ON ue.userid=u.id
						JOIN mdl_enrol e ON e.id=ue.enrolid
						JOIN mdl_course c ON c.id = e.courseid
						JOIN mdl_context AS ctx ON ctx.instanceid = c.id
						JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
						JOIN mdl_role AS r ON r.id = e.roleid

						WHERE ra.userid=u.id
						AND ctx.instanceid=c.id
						AND ra.roleid='3' 
						
						AND c.visible='1'
							/*AND ValueCompleted LIKE '%100%'*/
							AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
							FROM mdl_grade_grades AS gg 
							JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
							WHERE gi.courseid=c.id
							AND gg.userid=u.id
							AND gi.itemtype='mod'
							GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
							FROM mdl_grade_items AS gi 
							WHERE gi.courseid = c.id
							AND gi.itemtype='mod'), '0'))*100,0), '0')) != '100' 				
						GROUP BY u.id, c.id, ctx.id
						ORDER BY u.lastname, u.firstname, c.fullname) AS T1 

					JOIN ( SELECT c.id, a.contextid AS Cid, a.component, a.filearea, a.itemid, a.filepath, a.filename, a.userid, a.mimetype 
						FROM mdl_files a, mdl_context b, mdl_course c 
						WHERE a.mimetype LIKE 'image%' 
						AND a.component = 'course'
						AND a.contextid = b.id ) AS T2 

					ON T1.id = T2.id
					AND T1.Cid = T2.Cid
					AND T2.filearea = 'summary'
                                        ORDER BY T1.ke3 ASC";
	// Course Enroll Teacher List SUM
	$queteacher2s = "SELECT * 
					FROM (SELECT u.id AS ke3, c.id, ctx.id AS Cid, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
						IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
						FROM mdl_log log
						WHERE log.course=c.id
						AND log.userid=u.id), 'Never') AS 'First Access',

						IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
						FROM mdl_user_lastaccess la
						WHERE la.userid=u.id
						AND la.courseid=c.id),'Never') AS 'Last Access',
						  
						  (SELECT COUNT(u.id)) AS 'JumlahBero'
						
						FROM mdl_user u
						JOIN mdl_user_enrolments ue ON ue.userid=u.id
						JOIN mdl_enrol e ON e.id=ue.enrolid
						JOIN mdl_course c ON c.id = e.courseid
						JOIN mdl_context AS ctx ON ctx.instanceid = c.id
						JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
						JOIN mdl_role AS r ON r.id = e.roleid

						WHERE ra.userid=u.id
						AND ctx.instanceid=c.id
						AND ra.roleid='3' 
									
						AND c.visible='1'
								/*AND ValueCompleted LIKE '%100%'*/
								AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
								FROM mdl_grade_grades AS gg 
								JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
								WHERE gi.courseid=c.id
								AND gg.userid=u.id
								AND gi.itemtype='mod'
								GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
								FROM mdl_grade_items AS gi 
								WHERE gi.courseid = c.id
								AND gi.itemtype='mod'), '0'))*100,0), '0')) != '100' 				
						GROUP BY u.id
						ORDER BY u.lastname, u.firstname, c.fullname) 
					AS T1 

					JOIN ( SELECT c.id, a.contextid AS Cid, a.component, a.filearea, a.itemid, a.filepath, a.filename, a.userid, a.mimetype 
						  FROM mdl_files a, mdl_context b, mdl_course c 
						  WHERE a.mimetype LIKE 'image%' 
						  AND a.component = 'course'
						  AND a.contextid = b.id ) 
					AS T2 

					ON T1.id = T2.id
					AND T1.Cid = T2.Cid";			
	//Course Enroll as Teacher and Student
	$queTS2 = "SELECT u.id, u.firstname, c.fullname, r.id AS idstatus, r.shortname
			   FROM mdl_role r, mdl_role_assignments ra, mdl_user u, mdl_context ctx, mdl_course c
			   WHERE r.id = ra.roleid 
			   AND ra.userid = u.id
			   AND ctx.id = ra.contextid
			   AND ctx.contextlevel = '50'
			   AND ctx.instanceid = c.id
					AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
					FROM mdl_grade_grades AS gg 
					JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
					WHERE gi.courseid=c.id
					AND gg.userid=u.id
					AND gi.itemtype='mod'
					GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
					FROM mdl_grade_items AS gi 
					WHERE gi.courseid = c.id
					AND gi.itemtype='mod'), '0'))*100,0), '0')) != '100' 
				ORDER BY `u`.`firstname` ASC";
	//Course Statistic
	$queee2 = "SELECT id, shortname FROM `mdl_course` WHERE 1 ORDER BY `mdl_course`.`id` ASC";				
	//Course List Admin
	$queee3 = "SELECT c.id,c.fullname, a.contextid AS Cid, a.component, a.filearea, a.itemid, a.filepath, a.filename, a.userid, a.mimetype 
				FROM mdl_files a, mdl_context b, mdl_course c 
				WHERE a.mimetype LIKE 'image%' 
				AND a.component = 'course'
				AND a.contextid = b.id 
				AND a.filearea = 'summary'
                                AND b.instanceid = c.id";					
	// most enrol
	$que3 = "SELECT * 
			FROM (SELECT c.id, c.fullname, a.contextid AS Cid, a.component, a.filearea, a.itemid, a.filepath, a.filename, a.userid, a.mimetype 
				  FROM mdl_files a, mdl_context b, mdl_course c 
				  WHERE a.mimetype LIKE 'image%' 
				  AND a.component = 'course'
				  AND a.contextid = b.id) 
			AS T1 

			JOIN ( SELECT c.id, b.id AS Cids, COUNT( a.userid ) AS 'Participants' 
				  FROM mdl_role_assignments a 
				  JOIN mdl_context b ON a.contextid = b.id
				  JOIN mdl_course c ON b.instanceid = c.id
				  JOIN mdl_user d ON a.userid = d.id 
				  WHERE b.contextlevel = '50' 
				  GROUP BY b.instanceid, c.fullname ) 
			AS T2 

			ON T1.id = T2.id
			AND T1.Cid = T2.Cids
                        AND T1.filearea = 'summary'
			ORDER BY `T2`.`Participants` DESC";
	// most view
	$que4 = "SELECT * 
			FROM (SELECT a.id, a.fullname AS CourseName, COUNT( b.action =  'view%' ) AS viewss
			FROM mdl_course a, mdl_log b
			WHERE b.course = a.id
			AND b.module = 'course'
			GROUP BY a.id
		   ) AS T1 

			JOIN ( SELECT a.contextid, a.component, a.filearea, a.itemid, a.filepath, a.filename, a.userid, a.mimetype, b.instanceid 
				  FROM mdl_files a, mdl_context b
				  WHERE a.mimetype LIKE 'image%' 
				  AND a.component = 'course'
				  AND a.contextid = b.id
				   AND a.filearea = 'summary'
				  GROUP BY a.contextid
				   )  AS T2 
				   
	ON T1.id = T2.instanceid
			GROUP BY `T1`.`viewss` DESC";
	// messages
	$que6 = "SELECT * 
			FROM (
			  SELECT a.id, a.useridfrom AS dari, a.useridto AS ke, a.subject, a.fullmessage, a.fullmessageformat, a.smallmessage, a.timecreated 
			  FROM mdl_message a, mdl_user b
			  WHERE a.useridto = b.id
				) AS T1

			JOIN (
			  SELECT a.useridfrom AS dari2, a.useridto AS ke2, a.subject AS subject2, a.smallmessage AS smallmessage2, COUNT(a.useridto) AS notif
			  FROM mdl_message a, mdl_user b
			  WHERE a.useridto = b.id
			  AND fullmessageformat = 0
			  GROUP BY ke2
				) AS T2 

			ON T1.ke = T2.ke2
			WHERE T1.fullmessageformat =0";
	// progress bar incomplete
	$que7 = "SELECT u.id AS ke3, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
			IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 'Never') AS 'First Access',

			(SELECT IF(ue.STATUS=0, ' ', 'Withdrawn')) AS 'Withdrawn',
			IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
			FROM mdl_user_lastaccess la
			WHERE la.userid=u.id
			AND la.courseid=c.id),'Never') AS 'Last Access',

	(SELECT COUNT(u.id)) AS 'Jumlahbero',

			/*A count of the number of distinct days a student has entered a course*/
			IFNULL((SELECT COUNT(DISTINCT FROM_UNIXTIME(log.TIME, '%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id
			AND log.action='view'
			AND log.module='course'
			GROUP BY u.id
			),'0') AS '# Days Accessed',

			IFNULL((SELECT COUNT(gg.finalgrade) 
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='mod'
			GROUP BY u.id,c.id),'0') AS 'Activities Completed',

			IFNULL((SELECT COUNT(gi.itemname) 
			FROM mdl_grade_items AS gi 
			WHERE gi.courseid = c.id
			AND gi.itemtype='mod'), '0') AS 'Activities Assigned',

			/*If Activities completed = activities assigned, show date of last log entry. Otherwise, show percentage complete. If Activities Assigned = 0, show 'n/a'.--*/
			(SELECT IF(`Activities Assigned`!='0', (SELECT IF((`Activities Completed`)=(`Activities Assigned`), 
										   
			/*--Last log entry--*/
			(SELECT CONCAT('100% completed ',FROM_UNIXTIME(MAX(log.TIME),'%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 
			
			/*--Percent completed--*/
			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'),'% complete')))), 'n/a')) AS 'CourseCompleted',

			IFNULL(CONCAT(ROUND((SELECT (IFNULL((SELECT SUM(gg.finalgrade)
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			GROUP BY u.id,c.id),0)/(SELECT SUM(gi.grademax)
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			AND gg.finalgrade IS NOT NULL
			GROUP BY u.id,c.id))*100),0),'%'),'n/a')  AS 'Quality of Work to Date',

			(SELECT IF(`Activities Assigned`!='0',CONCAT(IFNULL(ROUND(((SELECT gg.finalgrade/gi.grademax
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='course'
			GROUP BY 'gi.courseid')*100),0),'0'),'%'),'n/a')) AS 'Final Score (incl xtra credit)',

			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'))) AS 'ValueCompleted'
			
			FROM mdl_user u
			JOIN mdl_user_enrolments ue ON ue.userid=u.id
			JOIN mdl_enrol e ON e.id=ue.enrolid
			JOIN mdl_course c ON c.id = e.courseid
			JOIN mdl_context AS ctx ON ctx.instanceid = c.id
			JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
			JOIN mdl_role AS r ON r.id = e.roleid

			WHERE ra.userid=u.id
			AND ctx.instanceid=c.id
			AND ra.roleid='5' 
			AND c.visible='1'
				/*AND ValueCompleted LIKE '%100%'*/
				AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
				FROM mdl_grade_grades AS gg 
				JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
				WHERE gi.courseid=c.id
				AND gg.userid=u.id
				AND gi.itemtype='mod'
				GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
				FROM mdl_grade_items AS gi 
				WHERE gi.courseid = c.id
				AND gi.itemtype='mod'), '0'))*100,0), '0')) > '100' 
			GROUP BY u.id
			ORDER BY u.lastname, u.firstname, c.fullname";        
	// progress bar completed
	$que8 = "SELECT u.id AS ke3, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
			IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 'Never') AS 'First Access',

			(SELECT IF(ue.STATUS=0, ' ', 'Withdrawn')) AS 'Withdrawn',
			IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
			FROM mdl_user_lastaccess la
			WHERE la.userid=u.id
			AND la.courseid=c.id),'Never') AS 'Last Access',

	(SELECT COUNT(u.id)) AS 'Jumlahbero',

			/*A count of the number of distinct days a student has entered a course*/
			IFNULL((SELECT COUNT(DISTINCT FROM_UNIXTIME(log.TIME, '%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id
			AND log.action='view'
			AND log.module='course'
			GROUP BY u.id
			),'0') AS '# Days Accessed',

			IFNULL((SELECT COUNT(gg.finalgrade) 
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='mod'
			GROUP BY u.id,c.id),'0') AS 'Activities Completed',

			IFNULL((SELECT COUNT(gi.itemname) 
			FROM mdl_grade_items AS gi 
			WHERE gi.courseid = c.id
			AND gi.itemtype='mod'), '0') AS 'Activities Assigned',

			/*If Activities completed = activities assigned, show date of last log entry. Otherwise, show percentage complete. If Activities Assigned = 0, show 'n/a'.--*/
			(SELECT IF(`Activities Assigned`!='0', (SELECT IF((`Activities Completed`)=(`Activities Assigned`), 
										   
			/*--Last log entry--*/
			(SELECT CONCAT('100% completed ',FROM_UNIXTIME(MAX(log.TIME),'%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 
			
			/*--Percent completed--*/
			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'),'% complete')))), 'n/a')) AS 'CourseCompleted',

			IFNULL(CONCAT(ROUND((SELECT (IFNULL((SELECT SUM(gg.finalgrade)
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			GROUP BY u.id,c.id),0)/(SELECT SUM(gi.grademax)
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			AND gg.finalgrade IS NOT NULL
			GROUP BY u.id,c.id))*100),0),'%'),'n/a')  AS 'Quality of Work to Date',

			(SELECT IF(`Activities Assigned`!='0',CONCAT(IFNULL(ROUND(((SELECT gg.finalgrade/gi.grademax
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='course'
			GROUP BY 'gi.courseid')*100),0),'0'),'%'),'n/a')) AS 'Final Score (incl xtra credit)',

			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'))) AS 'ValueCompleted'
			
			FROM mdl_user u
			JOIN mdl_user_enrolments ue ON ue.userid=u.id
			JOIN mdl_enrol e ON e.id=ue.enrolid
			JOIN mdl_course c ON c.id = e.courseid
			JOIN mdl_context AS ctx ON ctx.instanceid = c.id
			JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
			JOIN mdl_role AS r ON r.id = e.roleid

			WHERE ra.userid=u.id
			AND ctx.instanceid=c.id
			AND ra.roleid='5' 
			AND c.visible='1'
				/*AND ValueCompleted LIKE '%100%'*/
				AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
				FROM mdl_grade_grades AS gg 
				JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
				WHERE gi.courseid=c.id
				AND gg.userid=u.id
				AND gi.itemtype='mod'
				GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
				FROM mdl_grade_items AS gi 
				WHERE gi.courseid = c.id
				AND gi.itemtype='mod'), '0'))*100,0), '0')) LIKE '%100%'
			GROUP BY u.id
			ORDER BY u.lastname, u.firstname, c.fullname";
	// progress bar not attempted
	$que12 = "SELECT u.id AS ke3, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
			IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 'Never') AS 'First Access',

			(SELECT IF(ue.STATUS=0, ' ', 'Withdrawn')) AS 'Withdrawn',
			IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
			FROM mdl_user_lastaccess la
			WHERE la.userid=u.id
			AND la.courseid=c.id),'Never') AS 'Last Access',

	(SELECT COUNT(u.id)) AS 'Jumlahbero',

			/*A count of the number of distinct days a student has entered a course*/
			IFNULL((SELECT COUNT(DISTINCT FROM_UNIXTIME(log.TIME, '%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id
			AND log.action='view'
			AND log.module='course'
			GROUP BY u.id
			),'0') AS '# Days Accessed',

			IFNULL((SELECT COUNT(gg.finalgrade) 
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='mod'
			GROUP BY u.id,c.id),'0') AS 'Activities Completed',

			IFNULL((SELECT COUNT(gi.itemname) 
			FROM mdl_grade_items AS gi 
			WHERE gi.courseid = c.id
			AND gi.itemtype='mod'), '0') AS 'Activities Assigned',

			/*If Activities completed = activities assigned, show date of last log entry. Otherwise, show percentage complete. If Activities Assigned = 0, show 'n/a'.--*/
			(SELECT IF(`Activities Assigned`!='0', (SELECT IF((`Activities Completed`)=(`Activities Assigned`), 
										   
			/*--Last log entry--*/
			(SELECT CONCAT('100% completed ',FROM_UNIXTIME(MAX(log.TIME),'%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 
			
			/*--Percent completed--*/
			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'),'% complete')))), 'n/a')) AS 'CourseCompleted',

			IFNULL(CONCAT(ROUND((SELECT (IFNULL((SELECT SUM(gg.finalgrade)
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			GROUP BY u.id,c.id),0)/(SELECT SUM(gi.grademax)
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			AND gg.finalgrade IS NOT NULL
			GROUP BY u.id,c.id))*100),0),'%'),'n/a')  AS 'Quality of Work to Date',

			(SELECT IF(`Activities Assigned`!='0',CONCAT(IFNULL(ROUND(((SELECT gg.finalgrade/gi.grademax
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='course'
			GROUP BY 'gi.courseid')*100),0),'0'),'%'),'n/a')) AS 'Final Score (incl xtra credit)',

			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'))) AS 'ValueCompleted'
			
			FROM mdl_user u
			JOIN mdl_user_enrolments ue ON ue.userid=u.id
			JOIN mdl_enrol e ON e.id=ue.enrolid
			JOIN mdl_course c ON c.id = e.courseid
			JOIN mdl_context AS ctx ON ctx.instanceid = c.id
			JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
			JOIN mdl_role AS r ON r.id = e.roleid

			WHERE ra.userid=u.id
			AND ctx.instanceid=c.id
			AND ra.roleid='5' 
			AND c.visible='1'
				/*AND ValueCompleted LIKE '%100%'*/
				AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
				FROM mdl_grade_grades AS gg 
				JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
				WHERE gi.courseid=c.id
				AND gg.userid=u.id
				AND gi.itemtype='mod'
				GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
				FROM mdl_grade_items AS gi 
				WHERE gi.courseid = c.id
				AND gi.itemtype='mod'), '0'))*100,0), '0')) ='0'
			GROUP BY u.id
			ORDER BY u.lastname, u.firstname, c.fullname";        
	//course progress incomplete
	$que9 = "SELECT u.id AS ke3, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
			IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 'Never') AS 'First Access',

			(SELECT IF(ue.STATUS=0, ' ', 'Withdrawn')) AS 'Withdrawn',
			IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
			FROM mdl_user_lastaccess la
			WHERE la.userid=u.id
			AND la.courseid=c.id),'Never') AS 'Last Access',

	(SELECT COUNT(u.id)) AS 'Jumlahbero',

			/*A count of the number of distinct days a student has entered a course*/
			IFNULL((SELECT COUNT(DISTINCT FROM_UNIXTIME(log.TIME, '%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id
			AND log.action='view'
			AND log.module='course'
			GROUP BY u.id
			),'0') AS '# Days Accessed',

			IFNULL((SELECT COUNT(gg.finalgrade) 
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='mod'
			GROUP BY u.id,c.id),'0') AS 'Activities Completed',

			IFNULL((SELECT COUNT(gi.itemname) 
			FROM mdl_grade_items AS gi 
			WHERE gi.courseid = c.id
			AND gi.itemtype='mod'), '0') AS 'Activities Assigned',

			/*If Activities completed = activities assigned, show date of last log entry. Otherwise, show percentage complete. If Activities Assigned = 0, show 'n/a'.--*/
			(SELECT IF(`Activities Assigned`!='0', (SELECT IF((`Activities Completed`)=(`Activities Assigned`), 
										   
			/*--Last log entry--*/
			(SELECT CONCAT('100% completed ',FROM_UNIXTIME(MAX(log.TIME),'%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 
			
			/*--Percent completed--*/
			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'),'% complete')))), 'n/a')) AS 'CourseCompleted',

			IFNULL(CONCAT(ROUND((SELECT (IFNULL((SELECT SUM(gg.finalgrade)
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			GROUP BY u.id,c.id),0)/(SELECT SUM(gi.grademax)
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			AND gg.finalgrade IS NOT NULL
			GROUP BY u.id,c.id))*100),0),'%'),'n/a')  AS 'Quality of Work to Date',

			(SELECT IF(`Activities Assigned`!='0',CONCAT(IFNULL(ROUND(((SELECT gg.finalgrade/gi.grademax
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='course'
			GROUP BY 'gi.courseid')*100),0),'0'),'%'),'n/a')) AS 'Final Score (incl xtra credit)',

			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'))) AS 'ValueCompleted'
			
			FROM mdl_user u
			JOIN mdl_user_enrolments ue ON ue.userid=u.id
			JOIN mdl_enrol e ON e.id=ue.enrolid
			JOIN mdl_course c ON c.id = e.courseid
			JOIN mdl_context AS ctx ON ctx.instanceid = c.id
			JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
			JOIN mdl_role AS r ON r.id = e.roleid

			WHERE ra.userid=u.id
			AND ctx.instanceid=c.id
			AND ra.roleid='5' 
			AND c.visible='1'
				/*AND ValueCompleted LIKE '%100%'*/
				AND CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
				FROM mdl_grade_grades AS gg 
				JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
				WHERE gi.courseid=c.id
				AND gg.userid=u.id
				AND gi.itemtype='mod'
				GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
				FROM mdl_grade_items AS gi 
				WHERE gi.courseid = c.id
				AND gi.itemtype='mod'), '0'))*100,0), '0')) > '100' 
			GROUP BY u.id, c.id
			ORDER BY u.lastname, u.firstname, c.fullname";
	//course progress completed
	$que10 = "SELECT u.id AS ke3, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
			IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 'Never') AS 'First Access',

			(SELECT IF(ue.STATUS=0, ' ', 'Withdrawn')) AS 'Withdrawn',
			IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
			FROM mdl_user_lastaccess la
			WHERE la.userid=u.id
			AND la.courseid=c.id),'Never') AS 'Last Access',

			/*A count of the number of distinct days a student has entered a course*/
			IFNULL((SELECT COUNT(DISTINCT FROM_UNIXTIME(log.TIME, '%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id
			AND log.action='view'
			AND log.module='course'
			GROUP BY u.id
			),'0') AS '# Days Accessed',

			IFNULL((SELECT COUNT(gg.finalgrade) 
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='mod'
			GROUP BY u.id,c.id),'0') AS 'Activities Completed',

			IFNULL((SELECT COUNT(gi.itemname) 
			FROM mdl_grade_items AS gi 
			WHERE gi.courseid = c.id
			AND gi.itemtype='mod'), '0') AS 'Activities Assigned',

			/*If Activities completed = activities assigned, show date of last log entry. Otherwise, show percentage complete. If Activities Assigned = 0, show 'n/a'.--*/
			(SELECT IF(`Activities Assigned`!='0', (SELECT IF((`Activities Completed`)=(`Activities Assigned`), 
										   
			/*--Last log entry--*/
			(SELECT CONCAT('100% completed ',FROM_UNIXTIME(MAX(log.TIME),'%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 
			
			/*--Percent completed--*/
			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'),'% complete')))), 'n/a')) AS 'CourseCompleted',

			IFNULL(CONCAT(ROUND((SELECT (IFNULL((SELECT SUM(gg.finalgrade)
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			GROUP BY u.id,c.id),0)/(SELECT SUM(gi.grademax)
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			AND gg.finalgrade IS NOT NULL
			GROUP BY u.id,c.id))*100),0),'%'),'n/a')  AS 'Quality of Work to Date',

			(SELECT IF(`Activities Assigned`!='0',CONCAT(IFNULL(ROUND(((SELECT gg.finalgrade/gi.grademax
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='course'
			GROUP BY 'gi.courseid')*100),0),'0'),'%'),'n/a')) AS 'Final Score (incl xtra credit)',

			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'))) AS 'ValueCompleted'
			
			FROM mdl_user u
			JOIN mdl_user_enrolments ue ON ue.userid=u.id
			JOIN mdl_enrol e ON e.id=ue.enrolid
			JOIN mdl_course c ON c.id = e.courseid
			JOIN mdl_context AS ctx ON ctx.instanceid = c.id
			JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
			JOIN mdl_role AS r ON r.id = e.roleid

			WHERE ra.userid=u.id
			AND ctx.instanceid=c.id
			AND ra.roleid='5' 
			AND c.visible='1'
				/* ValueCompleted LIKE '%100%'*/
				AND (CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
				FROM mdl_grade_grades AS gg 
				JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
				WHERE gi.courseid=c.id
				AND gg.userid=u.id
				AND gi.itemtype='mod'
				GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
				FROM mdl_grade_items AS gi 
				WHERE gi.courseid = c.id
				AND gi.itemtype='mod'), '0'))*100,0), '0'))) LIKE '%100%'
			GROUP BY u.id, c.id
			ORDER BY u.lastname, u.firstname, c.fullname";
	//course progress not attempted
	$que11 = "SELECT u.id AS ke3, u.firstname AS 'First Name', u.lastname AS 'Last Name', c.fullname AS 'Course', FROM_UNIXTIME(ue.timecreated, '%m/%d/%Y') AS 'Enrolled',
			IFNULL((SELECT DATE_FORMAT(MIN(FROM_UNIXTIME(log.TIME)),'%d/%m/%Y')
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 'Never') AS 'First Access',

			(SELECT IF(ue.STATUS=0, ' ', 'Withdrawn')) AS 'Withdrawn',
			IFNULL((SELECT DATE_FORMAT(FROM_UNIXTIME(la.timeaccess), '%d/%m/%Y')
			FROM mdl_user_lastaccess la
			WHERE la.userid=u.id
			AND la.courseid=c.id),'Never') AS 'Last Access',

			/*A count of the number of distinct days a student has entered a course*/
			IFNULL((SELECT COUNT(DISTINCT FROM_UNIXTIME(log.TIME, '%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id
			AND log.action='view'
			AND log.module='course'
			GROUP BY u.id
			),'0') AS '# Days Accessed',

			IFNULL((SELECT COUNT(gg.finalgrade) 
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='mod'
			GROUP BY u.id,c.id),'0') AS 'Activities Completed',

			IFNULL((SELECT COUNT(gi.itemname) 
			FROM mdl_grade_items AS gi 
			WHERE gi.courseid = c.id
			AND gi.itemtype='mod'), '0') AS 'Activities Assigned',

			/*If Activities completed = activities assigned, show date of last log entry. Otherwise, show percentage complete. If Activities Assigned = 0, show 'n/a'.--*/
			(SELECT IF(`Activities Assigned`!='0', (SELECT IF((`Activities Completed`)=(`Activities Assigned`), 
										   
			/*--Last log entry--*/
			(SELECT CONCAT('100% completed ',FROM_UNIXTIME(MAX(log.TIME),'%d/%m/%Y'))
			FROM mdl_log log
			WHERE log.course=c.id
			AND log.userid=u.id), 
			
			/*--Percent completed--*/
			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'),'% complete')))), 'n/a')) AS 'CourseCompleted',

			IFNULL(CONCAT(ROUND((SELECT (IFNULL((SELECT SUM(gg.finalgrade)
			FROM mdl_grade_grades AS gg 
			JOIN mdl_grade_items AS gi ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			GROUP BY u.id,c.id),0)/(SELECT SUM(gi.grademax)
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gi.id=gg.itemid
			WHERE gg.itemid=gi.id
			AND gi.courseid=c.id
			AND gi.itemtype='mod'
			AND gg.userid=u.id
			AND gg.finalgrade IS NOT NULL
			GROUP BY u.id,c.id))*100),0),'%'),'n/a')  AS 'Quality of Work to Date',

			(SELECT IF(`Activities Assigned`!='0',CONCAT(IFNULL(ROUND(((SELECT gg.finalgrade/gi.grademax
			FROM mdl_grade_items AS gi
			JOIN mdl_grade_grades AS gg ON gg.itemid=gi.id
			WHERE gi.courseid=c.id
			AND gg.userid=u.id
			AND gi.itemtype='course'
			GROUP BY 'gi.courseid')*100),0),'0'),'%'),'n/a')) AS 'Final Score (incl xtra credit)',

			(SELECT CONCAT(IFNULL(ROUND((`Activities Completed`)/(`Activities Assigned`)*100,0), '0'))) AS 'ValueCompleted'
			
			FROM mdl_user u
			JOIN mdl_user_enrolments ue ON ue.userid=u.id
			JOIN mdl_enrol e ON e.id=ue.enrolid
			JOIN mdl_course c ON c.id = e.courseid
			JOIN mdl_context AS ctx ON ctx.instanceid = c.id
			JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
			JOIN mdl_role AS r ON r.id = e.roleid

			WHERE ra.userid=u.id
			AND ctx.instanceid=c.id
			AND ra.roleid='5' 
			AND c.visible='1'
				/* ValueCompleted LIKE '%100%'*/
				AND (CONCAT(IFNULL(ROUND((IFNULL((SELECT COUNT(gg.finalgrade) 
				FROM mdl_grade_grades AS gg 
				JOIN mdl_grade_items AS gi ON gg.itemid=gi.id
				WHERE gi.courseid=c.id
				AND gg.userid=u.id
				AND gi.itemtype='mod'
				GROUP BY u.id,c.id),'0'))/(IFNULL((SELECT COUNT(gi.itemname) 
				FROM mdl_grade_items AS gi 
				WHERE gi.courseid = c.id
				AND gi.itemtype='mod'), '0'))*100,0), '0'))) = '0'
			GROUP BY u.id, c.id
			ORDER BY u.lastname, u.firstname, c.fullname";        
	//calendar events
	$que13 = "SELECT e.name, e.eventtype, e.timestart, e.timeduration, c.fullname
			FROM mdl_event e, mdl_course c 
			WHERE e.courseid = c.id
			AND e.eventtype != 'user'";
	//visitors
	$que14 = "SELECT *
				FROM (SELECT uid.data AS Region,
				count( uid.userid ) AS JumlahEnrollRegion
				 
				FROM mdl_course c, mdl_user_info_data uid, mdl_enrol en, mdl_user_enrolments ue, mdl_user user2 
				WHERE (SELECT shortname FROM mdl_role WHERE id=en.roleid) = 'student'
				AND en.courseid = c.id
				AND ue.enrolid = en.id
				AND ue.userid = user2.id
				AND uid.userid = user2.id
				AND uid.fieldid = '1'
				GROUP BY Region) AS T1

				JOIN (SELECT data, count(userid) as registered 
					  FROM mdl_user_info_data 
					  WHERE fieldid = 1
					  GROUP BY data) AS T2
			  
				ON T1.Region = T2.data
				ORDER BY `T1`.`JumlahEnrollRegion`  DESC";
				
	
		// role user
		$cou= mysqli_query($con, $que);
		while ($cour = mysqli_fetch_object($cou)){
			$cour->Sum= file_rewrite_pluginfile_urls($cour->Sum, 'pluginfile.php',$cour->contextid, 'course', 'summary', NULL);
			$output3 = $cour->Sum;
		}
		// role user v.1
		$couu= mysqli_query($con, $quee);
		while ($courr = mysqli_fetch_object($couu)){
			$ucer = $courr->userid;
			$status = $courr->data;
			$membersincee = $courr->membersince;
			$arucer[] = $ucer;
			$arstatus[] = $status;
			$armembersince[] = $membersincee;
		}            
		// course enroll student list
		$coustudent2 = mysqli_query($con, $questudent2);        
		while ($cour2 = mysqli_fetch_object($coustudent2)){
			$userkurid = $cour2->ke3;
			$namakursus = $cour2->Course;
			$kursusid = $cour2->id;
			$contextid2 = $cour2->Cid;
			$filename2 = $cour2->filename;
			$aa[] = $namakursus;
			$bb[] = $kursusid;
			$cc[] = $userkurid;
			$e[] = $contextid2;
			$f[] = $filename2;
		}
		// course enroll student list SUM
		$couStu2s = mysqli_query($con, $questudent2s);
		while ($cour2s = mysqli_fetch_object($couStu2s)){
			$JmhEnrollCid = $cour2s->ke3;
			$JmhEnrollCourse = $cour2s->JumlahBero;
			$arJmhEnrollCid[] = $JmhEnrollCid;
			$arJmhEnrollCourse[] = $JmhEnrollCourse;
		}
		// course enroll teacher list
		$couteacher2 = mysqli_query($con, $queteacher2);        
		while ($Tcour2 = mysqli_fetch_object($couteacher2)){
			$Tuserkurid = $Tcour2->ke3;
			$Tnamakursus = $Tcour2->Course;
			$Tkursusid = $Tcour2->id;
			$Tcontextid2 = $Tcour2->Cid;
			$Tfilename2 = $Tcour2->filename;
			$Taa[] = $Tnamakursus;
			$Tbb[] = $Tkursusid;
			$Tcc[] = $Tuserkurid;
			$Te[] = $Tcontextid2;
			$Tf[] = $Tfilename2;
		}
		// course enroll teacher list SUM
		$couTeac2s = mysqli_query($con, $queteacher2s);
		while ($Tcour2s = mysqli_fetch_object($couTeac2s)){
			$TJmhEnrollCid = $Tcour2s->ke3;
			$TJmhEnrollCourse = $Tcour2s->JumlahBero;
			$TarJmhEnrollCid[] = $TJmhEnrollCid;
			$TarJmhEnrollCourse[] = $TJmhEnrollCourse;
		}		
		// Course Enroll List as Teacher and Student
		$couTS2 = mysqli_query($con, $queTS2);
		//$resultrow2 = mysqli_num_rows($couTS2);
		while ($courTS2 = mysqli_fetch_object($couTS2)){
			$courseidTS = $courTS2->id;
			$statusidTS = $courTS2->idstatus;
			$statusnameTS = $courTS2->shortname;
			$arcourseidTS[] = $courseidTS;
			$arstatusidTS[] = $statusidTS;
			$arstatusnameTS[] = $statusnameTS;
		}
		//Course Statistic
		$couuu2 = mysqli_query($con, $queee2);
		$resultrow2 = mysqli_num_rows($couuu2);
		while ($courrr2 = mysqli_fetch_object($couuu2)){
			$courseidd = $courrr2->id;
			$coursenamed = $courrr2->shortname;
			$arcourseidd[] = $courseidd;
			$arcoursenamed[] = $coursenamed;
		}	
		//Course List Admin
		$couuu22 = mysqli_query($con, $queee3);
		$resultrow22 = mysqli_num_rows($couuu22);
		while ($courrr22 = mysqli_fetch_object($couuu22)){
			$courseidd2 = $courrr22->id;
			$coursenamed2 = $courrr22->fullname;
			$coursegambaridd = $courrr22->Cid;
			$coursegambard = $courrr22->filename;
			$arcourseidd2[] = $courseidd2;
			$arcoursenamed2[] = $coursenamed2;
			$arcoursegambarid2[] = $coursegambaridd;
			$arcoursegambard2[] = $coursegambard;
		}				
		// most enrol
		$enrols = mysqli_query($con, $que3);
		$resultrow3 = mysqli_num_rows($enrols);
		while($enroll = mysqli_fetch_object($enrols)){
			$namacourse = $enroll->fullname;
			$idthumb = $enroll->Cid;
			$thumbdepan = $enroll->filename;
			$jumlahenrol = $enroll->Participants;
			$c[] = $namacourse;
			$d[] = $jumlahenrol;
			$g[] = $thumbdepan;
			$h[] = $idthumb;
		}
		// most view
		$views = mysqli_query($con, $que4);
		$resultrow = mysqli_num_rows($views);
		while($ask = mysqli_fetch_object($views)){      
			$scormn = $ask->CourseName;
			$viewsc = $ask->viewss;
			$idthumbview = $ask->contextid;
			$thumbview = $ask->filename;
			$a[] = $scormn;
			$b[] = $viewsc;
			$ee[] = $idthumbview;
			$ff[] = $thumbview;
		}        
		// messages
		$pesan = mysqli_query($con, $que6);
		while($surat = mysqli_fetch_object($pesan)){
			$dari = $surat->dari;
			$ke = $surat->ke;
			$ke2 = $surat->ke2;
			$subjek = $surat->subject;
			$fullmesej = $surat->fullmessage;
			$smallmesej = $surat->smallmessage;
			$notif = $surat->notif;
			$waktupesan = $surat->timecreated;
			$ardari[] = $dari;
			$arke[] = $ke;
			$arke2[] = $ke;
			$arsubjek[] = $subjek;
			$arsmallmesej[] = $smallmesej;
			$arnotif[] = $notif;
			$arwarpen[] = $waktupesan;
		}
		// course progress incomplete
		$piechart = mysqli_query($con, $que9);
		$resultrow6 = mysqli_num_rows($piechart);
		while($chartz = mysqli_fetch_object($piechart)){
			$nilaiid = $chartz->ke3;
			$nilaicourse = $chartz->Course;
			$nilaichart = $chartz->CourseCompleted;
			$nilaivalue = $chartz->ValueCompleted;
			$arnilaiid[] = $nilaiid;
			$arnilaicourse[] = $nilaicourse;
			$arnilaichart[] = $nilaichart;
			$arnilaivalue[] = $nilaivalue;
		}
		// course progress completed
		$piechart3 = mysqli_query($con, $que10);
		$resultrow8 = mysqli_num_rows($piechart3);
		while($chartz3 = mysqli_fetch_object($piechart3)){
			$nilaiid3 = $chartz3->ke3;
			$nilaicourse3 = $chartz3->Course;
			$nilaichart3 = $chartz3->CourseCompleted;
			$nilaivalue3 = $chartz3->ValueCompleted;
			$arnilaiid3[] = $nilaiid3;
			$arnilaicourse3[] = $nilaicourse3;
			$arnilaichart3[] = $nilaichart3;
			$arnilaivalue3[] = $nilaivalue3;
		}            
		// course progress not attempted
		$piechart4 = mysqli_query($con, $que11);
		$resultrow9 = mysqli_num_rows($piechart4);
		while($chartz4 = mysqli_fetch_object($piechart4)){
			$nilaiid4 = $chartz4->ke3;
			$nilaicourse4 = $chartz4->Course;
			$nilaichart4 = $chartz4->CourseCompleted;
			$nilaivalue4 = $chartz4->ValueCompleted;
			$arnilaiid4[] = $nilaiid4;
			$arnilaicourse4[] = $nilaicourse4;
			$arnilaichart4[] = $nilaichart4;
			$arnilaivalue4[] = $nilaivalue4;
		}            
		// progress bar incomplete
		$progressbar = mysqli_query($con, $que7);
		$resultrow7 = mysqli_num_rows($progressbar);
		while($probar = mysqli_fetch_object($progressbar)){
			$idk = $probar->ke3;
			$jmhenrol = $probar->Jumlahbero;
			$aridk[] = $idk;
			$arjmhenrol[] = $jmhenrol;
		}
		// progress bar completed
		$progressbar3 = mysqli_query($con, $que8);
		//$resultrow9 = mysqli_num_rows($progressbar3);
		while($probar3 = mysqli_fetch_object($progressbar3)){
			$ke33 = $probar3->ke3;
			$jmhenrol3 = $probar3->Jumlahbero;
			$aridk3[] = $ke33;
			$arjmhenrol3[] = $jmhenrol3;
		}    
		// progress bar not attempted
		$progressbar4 = mysqli_query($con, $que12);
		//$resultrow9 = mysqli_num_rows($progressbar3);
		while($probar4 = mysqli_fetch_object($progressbar4)){
			$ke34 = $probar4->ke3;
			$jmhenrol4 = $probar4->Jumlahbero;
			$aridk4[] = $ke34;
			$arjmhenrol4[] = $jmhenrol4;
		}        
		// event calendar
		$calendarx = mysqli_query($con, $que13);
		while($eventss = mysqli_fetch_object($calendarx)) {
			$eventcalendars = $eventss->name;
			$eventtypes = $eventss->eventtype;
			$eventtimestart = $eventss->timestart;
			$eventtimeduration = $eventss->timeduration;
			$eventcourse = $eventss->fullname;
			$areventcalendars[] = $eventcalendars;
			$areventtypes[] = $eventtypes;
			$areventtimestart[] = $eventtimestart;
			$areventtimeduration[] = $eventtimeduration;
			$areventcourse[] = $eventcourse;
		}
		// Visitors
		$visitors = mysqli_query($con, $que14);
		while($topactive = mysqli_fetch_object($visitors)){
			$regionss = $topactive->Region;
			$JmhEnrollReg = $topactive->JumlahEnrollRegion;
			$regis = $topactive->registered;
			$arregionss[] = $regionss;
			$arJmhEnrollReg[] = $JmhEnrollReg;
			$arregis[] = $regis;
		}
	//-------Database End-------//
?> 