<?php

	$db = mysqli_connect('localhost', 'root', '', 'myprojecthci');
	if(!$db){
		echo "Server is not correctly configured";
	}
	if (!mysqli_select_db($db,'myprojecthci')) {
		echo "Database is not correctly configured";
	}

	$title = mysqli_real_escape_string($db, $_POST['til']);
	$locator = mysqli_real_escape_string($db, $_POST['url']);
	$Evaluator = mysqli_real_escape_string($db, $_POST['user']);

	$qone = mysqli_real_escape_string($db, $_POST['A']);
	$star = mysqli_real_escape_string($db, $_POST['star']);
	$msg = mysqli_real_escape_string($db, $_POST['msg']);

	$qtwo = mysqli_real_escape_string($db, $_POST['B']);
	$star1 = mysqli_real_escape_string($db, $_POST['star1']);
	$msg1 = mysqli_real_escape_string($db, $_POST['msg1']);

	$qthree = mysqli_real_escape_string($db, $_POST['C']);
	$star2 = mysqli_real_escape_string($db, $_POST['star2']);
	$msg2 = mysqli_real_escape_string($db, $_POST['msg2']);

	$qfour = mysqli_real_escape_string($db, $_POST['D']);
	$star3 = mysqli_real_escape_string($db, $_POST['star3']);
	$msg3 = mysqli_real_escape_string($db, $_POST['msg3']);

	$qfive = mysqli_real_escape_string($db, $_POST['E']);
	$star4 = mysqli_real_escape_string($db, $_POST['star4']);
	$msg4 = mysqli_real_escape_string($db, $_POST['msg4']);

	$qsix = mysqli_real_escape_string($db, $_POST['F']);
	$star5 = mysqli_real_escape_string($db, $_POST['star5']);
	$msg5 = mysqli_real_escape_string($db, $_POST['msg5']);

	$qseven = mysqli_real_escape_string($db, $_POST['G']);
	$star6 = mysqli_real_escape_string($db, $_POST['star6']);
	$msg6 = mysqli_real_escape_string($db, $_POST['msg6']);

	$qeight = mysqli_real_escape_string($db, $_POST['H']);
	$star7 = mysqli_real_escape_string($db, $_POST['star7']);
	$msg7 = mysqli_real_escape_string($db, $_POST['msg7']);

	$qnine = mysqli_real_escape_string($db, $_POST['I']);
	$star8 = mysqli_real_escape_string($db, $_POST['star8']);
	$msg8 = mysqli_real_escape_string($db, $_POST['msg8']);

	$qten = mysqli_real_escape_string($db, $_POST['J']);
	$star9 = mysqli_real_escape_string($db, $_POST['star9']);
	$msg9 = mysqli_real_escape_string($db, $_POST['msg9']);

	$qeleven = mysqli_real_escape_string($db, $_POST['K']);
	$star10 = mysqli_real_escape_string($db, $_POST['star10']);
	$msg10 = mysqli_real_escape_string($db, $_POST['msg10']);

	$qtwelve = mysqli_real_escape_string($db, $_POST['L']);
	$star11 = mysqli_real_escape_string($db, $_POST['star11']);
	$msg11 = mysqli_real_escape_string($db, $_POST['msg11']);

	$qthirteen = mysqli_real_escape_string($db, $_POST['M']);
	$star12 = mysqli_real_escape_string($db, $_POST['star12']);
	$msg12 = mysqli_real_escape_string($db, $_POST['msg12']);

	$qfourteen = mysqli_real_escape_string($db, $_POST['N']);
	$star13 = mysqli_real_escape_string($db, $_POST['star13']);
	$msg13 = mysqli_real_escape_string($db, $_POST['msg13']);

	$qfifteen = mysqli_real_escape_string($db, $_POST['O']);
	$star14 = mysqli_real_escape_string($db, $_POST['star14']);
	$msg14 = mysqli_real_escape_string($db, $_POST['msg14']);

	$qsixteen = mysqli_real_escape_string($db, $_POST['P']);
	$star15 = mysqli_real_escape_string($db, $_POST['star15']);
	$msg15 = mysqli_real_escape_string($db, $_POST['msg15']);

	$qseventeen = mysqli_real_escape_string($db, $_POST['Q']);
	$star16 = mysqli_real_escape_string($db, $_POST['star16']);
	$msg16 = mysqli_real_escape_string($db, $_POST['msg16']);

	$qeighteen = mysqli_real_escape_string($db, $_POST['R']);
	$star17 = mysqli_real_escape_string($db, $_POST['star17']);
	$msg17 = mysqli_real_escape_string($db, $_POST['msg17']);

	$qnineteen = mysqli_real_escape_string($db, $_POST['S']);
	$star18 = mysqli_real_escape_string($db, $_POST['star18']);
	$msg18 = mysqli_real_escape_string($db, $_POST['msg18']);

	$qtwenty = mysqli_real_escape_string($db, $_POST['T']);
	$star19 = mysqli_real_escape_string($db, $_POST['star19']);
	$msg19 = mysqli_real_escape_string($db, $_POST['msg19']);

	$message = mysqli_real_escape_string($db, $_POST['messg']);



	$query = "INSERT INTO data (title, url, user) VALUES ('$title','$locator','$Evaluator')";
			mysqli_query($db, $query);
	// "INSERT INTO data(title, url, user) VALUES ('$title', '$url', '$user')";

	$query = "INSERT INTO heuristic (qa, ra, ma, qb, rb, mb, qc, rc, mc, qd, rd, md, qe, re, me, qf, rf, mf, qg, rg, mg, qh, rh, mh, qi, ri, mi, qj, rj, mj, qk, rk, mk, ql, rl, ml) VALUES ('$qone','$star','$msg','$qtwo','$star1','$msg1','$qthree','$star2','$msg2','$qfour','$star3','$msg3','$qfive','$star4','$msg4','$qsix','$star5','$msg5','$qseven','$star6','$msg6','$qeight','$star7','$msg7','$qnine','$star8','$msg8','$qten','$star9','$msg9','$qeleven','$star10','$msg10','$qtwelve','$star11','$msg11')";
			mysqli_query($db, $query);

	$query = "INSERT INTO golden (qa, ra, ma, qb, rb, mb, qc, rc, mc, qd, rd, md, qe, re, me, qf, rf, mf, qg, rg, mg, qh, rh, mh) VALUES ('$qone','$star','$msg','$qtwo','$star1','$msg1','$qthree','$star2','$msg2','$qfour','$star3','$msg3','$qfive','$star4','$msg4','$qsix','$star5','$msg5','$qseven','$star6','$msg6','$qeight','$star7','$msg7')";
			mysqli_query($db, $query);

	$query = "INSERT INTO evaluationdata (title, url, user, qa, ra, ma, qb, rb, mb, qc, rc, mc, qd, rd, md, qe, re, me, qf, rf, mf, qg, rg, mg, qh, rh, mh, qi, ri, mi, qj, rj, mj, qk, rk, mk, ql, rl, ml, qm, rm, mm, qn, rn, mn, qo, ro, mo, qp, rp, mp, qq, rq, mq, qr, rr, mr, qs, rs, ms, qt, rt, mt, messg) VALUES ('$title','$locator','$Evaluator','$qone','$star','$msg','$qtwo','$star1','$msg1','$qthree','$star2','$msg2','$qfour','$star3','$msg3','$qfive','$star4','$msg4','$qsix','$star5','$msg5','$qseven','$star6','$msg6','$qeight','$star7','$msg7','$qnine','$star8','$msg8','$qten','$star9','$msg9','$qeleven','$star10','$msg10','$qtwelve','$star11','$msg11','$qthirteen','$star12','$msg12','$qfourteen','$star13','$msg13','$qfifteen','$star14','$msg14','$qsixteen','$star15','$msg15','$qseventeen','$star16','$msg16','$qeighteen','$star17','$msg17','$qnineteen','$star18','$msg18','$qtwenty','$star19','$msg19','$message')";
			mysqli_query($db, $query);





	if (mysqli_query($db,'$query')) {
		echo "Sorry data is not inserted";
	}else{
		echo "Congrats!!! Data succesfully inserted to the Database";
		header('location: ./Report/index.php');
	}
?>