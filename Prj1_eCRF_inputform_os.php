<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['collID']) || !isset($_SESSION['collName'])) {
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	exit;
}
$user_id = $_SESSION['collID'];
$user_name = $_SESSION['collName'];
$user_email = $_SESSION['collEmail'];

define("GIT_VSCODE_TEST",1);
?>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<title>MDRIP - 의료영상 빅데이터 구축</title>
	
	<link rel="shortcut icon" href="favicon.ico">
	
		<!-- Bootstrap -->
		<link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="./vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="./vendors/nprogress/nprogress.css" rel="stylesheet">
		<!-- iCheck -->
		<link href="./vendors/iCheck/skins/flat/green.css" rel="stylesheet">
		
		<!-- bootstrap-wysiwyg -->
		<link href="./vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
		<!-- Select2 -->
		<link href="./vendors/select2/dist/css/select2.min.css" rel="stylesheet">
		<!-- Switchery -->
		<link href="./vendors/switchery/dist/switchery.min.css" rel="stylesheet">
		<!-- starrr -->
		<link href="./vendors/starrr/dist/starrr.css" rel="stylesheet">
		<!-- bootstrap-daterangepicker -->
		<link href="./vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
		<!-- bootstrap-datetimepicker -->
		<link href="./vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<!-- Ion.RangeSlider -->
		<link href="./vendors/normalize-css/normalize.css" rel="stylesheet">
		<link href="./vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet">
		<link href="./vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet">
		<!-- Dropzone.js -->
		<link href="./vendors/dropzone/dist/dropzone.css" rel="stylesheet">

		<!-- Custom Theme Style -->
		<link href="./css/custom.min.css" rel="stylesheet">
	<style>
.dropzone {
height: 200px;
min-height: 0px !important;
}	 
.dropzone.bg-left-ap{
	background-image:url(./img/left_ap.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.dropzone.bg-right-ap{
	background-image:url(./img/right_ap.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.dropzone.bg-left-lateral{
	background-image:url(./img/left_lateral.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.dropzone.bg-right-lateral{
	background-image:url(./img/right_lateral.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.dropzone.bg-whole{
	background-image:url(./img/whole.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.dropzone.bg-spine{
	background-image:url(./img/spine.gif);
	background-position:center center;
	background-repeat: no-repeat;
	height: 363px;
	min-height: 0px !important;
}
.dropzone.bg-left-hip-joint{
	background-image:url(./img/left_hip_joint.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.dropzone.bg-right-hip-joint{
	background-image:url(./img/right_hip_joint.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.dropzone.bg-xray-spine{
	background-image:url(./img/spine.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.dropzone.bg-xray-hip{
	background-image:url(./img/hip.gif);
	background-position:center center;
	background-repeat: no-repeat;
}
.modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>
	</head>

	<body class="nav-md ">
		<div class="container body">
			<div class="main_container">
				<div class="col-md-3 left_col menu_fixed">
					<div class="left_col scroll-view">
						<div class="navbar nav_title" style="border: 0;">
							<a href="index.php" class="site_title"><!--<i class="fa fa-paw"></i> <span>Gentelella Alela!</span>--><img src="./img/mdriplogo_small.gif" border="0"></a>				
						</div>
						<div class="clearfix"></div>
	
			
<!-- menu profile quick info -->
						<div class="profile clearfix">
							<div class="profile_pic">
								<img src="./img/user.png" alt="..." class="img-circle profile_img">
							</div>
							<div class="profile_info">
								<!--<span>Welcome,</span>-->
								<h2><?echo $user_name."<br><small>".$_SERVER['REMOTE_ADDR']."<br>".$_SESSION['collLastConn']."</small>";?></h2>
							</div>
						</div>
<!-- /menu profile quick info -->
						<br />

<!-- sidebar menu -->
<?include "./include/leftmenu.php";?>						
<!-- /sidebar menu -->

					</div>
				</div>

<!-- top navigation -->
<?include "./include/topnavi.php";?>
<!-- /top navigation -->

<!-- page content -->
				<div class="right_col" role="main">
					<div class="">
						<div class="page-title">
							<div class="title_left">
								<h3>골다공증 데이터 입력</h3>
							</div>
						</div>
						<div class="clearfix"></div>
						
						<!-- 방사선영상 패널 시작 -->
						<div class="col-md-12 col-xs-12">						
							<div class="x_panel">
								<div class="x_title">
									<h2>DXA Scan <small></small></h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="clearfix"></div>
									<form id="form_dxaimg" name="form_dxaimg" data-parsley-validate class="form-horizontal form-label-left" method="post">
										<input type="hidden" id="remReasonDXASpine" value="0">
										<input type="hidden" id="remReasonDXARHipJoint" value="0">
										<input type="hidden" id="remReasonDXALHipJoint" value="0">
										<input type="hidden" id="submitTypeDXA" name="submitTypeDXA" value="0">
										
										<div class="form-group" style="background-color:;">
											<label class="control-label col-md-1 col-sm-1 col-xs-12" for="patSeqID"> 연구번호</label>
											<div class="col-md-1 col-sm-1 col-xs-12">
												<input type="text" id="patSeqID4Dxa" name="patSeqID4Dxa" required="required" class="form-control col-md-4 col-xs-12" data-inputmask="'mask': 'OS-9999'">
											</div>
											<label class="control-label col-md-1 col-sm-1 col-xs-12">DXA 촬영</label>
											<div class="col-md-1 col-sm-1 col-xs-12">
												<input type="text" class="form-control" data-inputmask="'mask': '9999-99-99'" id="patDXADate" name="patDXADate">
											</div>
											<label class="control-label col-md-1 col-sm-1 col-xs-12">기기 종류</label>
											<div class="col-md-1 col-sm-1 col-xs-12">
												<select id="DXAManufac" name="DXAManufac" class="form-control">
													<option value="" disabled>DXA 모델</option>
													<option value="Hologic">Hologic</option>
													<option value="Lunar" selected>Lunar</option>
													<option value="Norland">Norland</option>
													<option value="etc">기타</option>
												</select>											
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group col-md-12">
											<div class="form-group col-md-4">
												<div class="col-md-5 col-sm-12 col-xs-12 form-group">								
													<div id="dxaSpine" class="dropzone bg-spine form-group col-md-12"></div>
												</div>
												<div class="col-md-7 col-sm-12 col-xs-12 form-group">
													<table class="col-md-12" border="0" cellspacing="0" cellpadding="0" style="border-color:#e4e4e4;">
														<tr height="20">
															<td class="col-md-3" align="center">Region</td>
															<td class="col-md-3" align="center">BMD</td>
															<td class="col-md-3" align="center">T-score</td>
															<td class="col-md-3" align="center">Z-score</td>
														</tr>
														<tr>
															<td align="center">L1</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1BMD" id="spval00"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1Tscore" id="spval01"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1Zscore" id="spval02"></td>
														</tr>
														<tr>
															<td align="center">L2</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2BMD" id="spval10"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2Tscore" id="spval11"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2Zscore" id="spval12"></td>
														</tr>
														<tr>
															<td align="center">L3</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L3BMD" id="spval20"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L3Tscore" id="spval21"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L3Zscore" id="spval22"></td>
														</tr>
														<tr>
															<td align="center">L4</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L4BMD" id="spval30"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L4Tscore" id="spval31"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L4Zscore" id="spval32"></td>
														</tr>
														<tr>
															<td align="center">L1 - L2</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L2BMD" id="spval40"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L2Tscore" id="spval41"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L2Zscore" id="spval42"></td>
														</tr>
														<tr>
															<td align="center">L1 - L3</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L3BMD" id="spval50"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L3Tscore" id="spval51"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L3Zscore" id="spval52"></td>
														</tr>
														<tr>
															<td align="center">L1 - L4</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L4BMD" id="spval60"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L4Tscore" id="spval61"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L1L4Zscore" id="spval62"></td>
														</tr>
														<tr>
															<td align="center">L2 - L3</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2L3BMD" id="spval70"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2L3Tscore" id="spval71"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2L3Zscore" id="spval72"></td>
														</tr>
														<tr>
															<td align="center">L2 - L4</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2L4BMD" id="spval80"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2L4Tscore" id="spval81"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L2L4Zscore" id="spval82"></td>
														</tr>
														<tr>
															<td align="center">L3 - L4</td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L3L4BMD" id="spval90"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L3L4Tscore" id="spval91"></td>
															<td><input type="text" class="form-control tab-dxa dxa-spine col-md-2" name="L3L4Zscore" id="spval92"></td>
														</tr>
													</table>
												</div>
											</div>
											<div class="form-group col-md-4">
												<div class="col-md-5 col-sm-12 col-xs-12 form-group">								
													<div id="dxaRtHipJoint" class="dropzone bg-right-hip-joint form-group col-md-12"></div>
												</div>
												<div class="col-md-7 col-sm-12 col-xs-12 form-group">
													<table class="col-md-12" border="0" cellspacing="0" cellpadding="0" style="border-color:#e4e4e4;">
														<tr height="20">
															<td class="col-md-3" align="center">Region</td>
															<td class="col-md-3" align="center">BMD</td>
															<td class="col-md-3" align="center">T-score</td>
															<td class="col-md-3" align="center">Z-score</td>
														</tr>
														<tr>
															<td align="center">Neck</td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipNeckBMD" id="rhval00"></td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipNeckTscore" id="rhval01"></td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipNeckZscore" id="rhval02"></td>
														</tr>
														<tr>
															<td align="center">Up Neck</td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipUpNeckBMD" id="rhval10"></td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipUpNeckTscore" id="rhval11"></td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipUpNeckZscore" id="rhval12"></td>
														</tr>
														<tr>
															<td align="center">Troch</td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipTrochBMD" id="rhval20"></td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipTrochTscore" id="rhval21"></td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipTrochZscore" id="rhval22"></td>
														</tr>
														<tr>
															<td align="center">Total</td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipTotalBMD" id="rhval30"></td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipTotalTscore" id="rhval31"></td>
															<td><input type="text" class="form-control tab-dxa dxa-rhip col-md-3" name="RHipTotalZscore" id="rhval32"></td>
														</tr>
													</table>
												</div>
											</div>
											<div class="form-group col-md-4">
												<div class="col-md-5 col-sm-12 col-xs-12 form-group">								
													<div id="dxaLtHipJoint" class="dropzone bg-left-hip-joint form-group col-md-12"></div>
												</div>
												<div class="col-md-7 col-sm-12 col-xs-12 form-group">
													<table class="col-md-12" border="0" cellspacing="0" cellpadding="0" style="border-color:#e4e4e4;">
														<tr height="20">
															<td class="col-md-3" align="center">Region</td>
															<td class="col-md-3" align="center">BMD<small></small></td>
															<td class="col-md-3" align="center">T-score</td>
															<td class="col-md-3" align="center">Z-score</td>
														</tr>
														<tr>
															<td align="center">Neck</td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipNeckBMD" id="lhval00"></td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipNeckTscore" id="lhval01"></td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipNeckZscore" id="lhval02"></td>
														</tr>
														<tr>
															<td align="center">Up Neck</td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipUpNeckBMD" id="lhval10"></td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipUpNeckTscore" id="lhval11"></td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipUpNeckZscore" id="lhval12"></td>
														</tr>
														<tr>
															<td align="center">Troch</td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipTrochBMD" id="lhval20"></td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipTrochTscore" id="lhval21"></td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipTrochZscore" id="lhval22"></td>
														</tr>
														<tr>
															<td align="center">Total</td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipTotalBMD" id="lhval30"></td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipTotalTscore" id="lhval31"></td>
															<td><input type="text" class="form-control tab-dxa dxa-lhip col-md-3" name="LHipTotalZscore" id="lhval32"></td>
														</tr>
													</table>
												</div>
											</div>
											
										</div>										
										<div class="clearfix"></div>
										<div class="ln_solid"></div>
										<div class="form-group">
											<div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-5">
												<button class="btn btn-primary" type="reset" onClick="clearDxaPannel();">Reset</button>
												<button type="button" class="btn btn-success" id="submitBtnDXA" onClick="submitDxaPannel();">Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						
						
						
						<!--
						<div class="col-md-12 col-xs-12">						
							<div class="x_panel">
								<div class="x_title">
									<h2>방사선영상 <small></small></h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="clearfix"></div>
									<form id="form_crimg" name="form_crimg" data-parsley-validate class="form-horizontal form-label-left" method="post">
										<input type="hidden" id="remReasonCRSpine" value="0">
										<input type="hidden" id="remReasonCRHip" value="0">
										
										<div class="form-group" style="background-color:;">
											<label class="control-label col-md-1 col-sm-1 col-xs-12" for="patSeqID"> 연구번호</label>
											<div class="col-md-1 col-sm-1 col-xs-12">
												<input type="text" id="patSeqID4Cr" name="patSeqID4Cr" required="required" class="form-control col-md-4 col-xs-12 form-ele-pat" data-inputmask="'mask': 'OS-9999'" onBlur="checkExist();">
											</div>
											<label class="control-label col-md-1 col-sm-1 col-xs-12">촬영일</label>
											<div class="col-md-1 col-sm-1 col-xs-12">
												<input type="text" class="form-control" data-inputmask="'mask': '9999-99-99'" id="patRadioDate" name="patRadioDate">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="col-md-12">
											<div class="form-group">
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">								
													<div id="radiographySpine" class="dropzone bg-xray-spine form-group col-md-12"></div>
												</div>											
												<div class="col-md-6 col-sm-12 col-xs-12 form-group">								
													<div id="radiographyHip" class="dropzone bg-xray-hip form-group col-md-12"></div>
												</div>
											</div>
											
										</div>
										<div class="clearfix"></div>										
										<div class="ln_solid"></div>
										<div class="form-group">
											<div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-5">
												<button class="btn btn-primary" type="reset" onClick="clearRadioPannel();">Reset</button>
												<button type="button" class="btn btn-success" onClick="clearRadioPannel();">Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>-->
						
						
<!-- 방사선영상 패널 끝 -->	
<!-- 환자정보 패널 시작 -->
						<div class="col-md-3 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>환자 정보 <small></small></h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="clearfix"></div>
									<form id="form_pat" name="form_pat" data-parsley-validate class="form-horizontal form-label-left" method="post">
										<input type="hidden" id="submitTypePat" name="submitTypePat" value="0">
										<div class="form-group">
											<label class="control-label col-md-5 col-sm-5 col-xs-12" for="patSeqID"> 연구번호</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="patSeqID" required="required" class="form-control col-md-4 col-xs-12 form-ele-pat" data-inputmask="'mask': 'OS-9999'" name="patSeqID">
											</div>
										</div>
										<!--<div class="ln_solid"></div>-->
										<div class="form-group">
											<label class="control-label col-md-5 col-sm-5 col-xs-12" for="last-name">진찰권번호 </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="patChartNumber" name="patChartNumber" class="form-control col-md-7 col-xs-12 form-ele-pat">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group">
											<label class="control-label col-md-5 col-sm-5 col-xs-12" for="last-name">성명 </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="patName" name="patName" class="form-control col-md-7 col-xs-12 form-ele-pat">
											</div>
										</div>
										<!--<div class="ln_solid"></div>-->
										<div class="form-group">
											<label class="control-label col-md-5 col-sm-5 col-xs-12" for="last-name">이니셜 </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="patInitial" name="patInitial" class="form-control col-md-7 col-xs-12 form-ele-pat">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group">
											<label class="control-label col-md-5 col-sm-5 col-xs-12">성별</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="radio" class="flat form-ele-pat" name="patGender" id="patGenderM" value="M" /><label for="patGenderM" style="cursor:pointer" class="control-label"> &nbsp; 남성</label> &nbsp; &nbsp; 
												<input type="radio" class="flat form-ele-pat" name="patGender" id="patGenderF" value="F" /><label for="patGenderF" style="cursor:pointer" class="control-label"> &nbsp; 여성</label>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group">
											<label class="control-label col-md-5 col-sm-5 col-xs-12" for="patBirthday">생년월일</label>												
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" class="form-control form-ele-pat" data-inputmask="'mask': '99-99-99'" id="patBirthday" name="patBirth" onblur="javascript:calcAge();">
											</div>
										</div>
										<!--<div class="ln_solid"></div>-->
										<div class="form-group">
											<label for="pat_Age" class="control-label col-md-5 col-sm-5 col-xs-12">나이</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="pat_Age" class="form-control col-md-7 col-xs-12 form-ele-pat" type="text" name="patAge">
											</div>
										</div>
										
										<div class="ln_solid"></div>
										<div class="form-group">
											<label class="control-label col-md-5 col-sm-5 col-xs-12">신장(cm) </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" id="patHeight" name="patHeight" class="form-control col-md-7 col-xs-12 form-ele-pat">
											</div>
										</div>
										<!--<div class="ln_solid"></div>-->
										<div class="form-group">
											<label for="patWeight" class="control-label col-md-5 col-sm-5 col-xs-12">체중(kg)</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="patWeight" class="form-control col-md-7 col-xs-12 form-ele-pat" type="text" name="patWeight" onblur="javascript:calcBMI();" onKeydown="javascript:checkEnter()">
											</div>
										</div>
										<!--<div class="ln_solid"></div>-->
										<div class="form-group">
											<label for="patBMI" class="control-label col-md-5 col-sm-5 col-xs-12">BMI(kg/㎡)</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="patBMI" class="form-control col-md-7 col-xs-12 form-ele-pat" type="text" name="patBMI">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group">
											<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
												<button class="btn btn-primary" type="reset" onclick="resetFormPat();">Reset</button>
												<button type="button" class="btn btn-success" id="submitBtnPat" onClick="submitPatInfo();">Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>		
<!-- 환자정보 패널 끝 -->
<!-- 임상정보 패널 시작 -->
						<div class="col-md-9 col-xs-12">						
							<div class="x_panel">
								<div class="x_title">
									<h2>임상 정보 <small></small></h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="clearfix"></div>
									<form id="form_clinic" name="form_clinic" data-parsley-validate class="form-horizontal form-label-left" method="post">
										<input type="hidden" name="patSeqID4Cli" id="patSeqID4Cli">
										<input type="hidden" id="submitTypeCli" name="submitTypeCli" value="0">
										
										<div class="form-group" style="background-color:;">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">진단명</label>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" id="patDiagnosis" name="patDiagnosis" class="form-control form-ele-cli" value="OS">
											</div>
											<label class="control-label col-md-3 col-sm-3 col-xs-12">진단일</label>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" class="form-control form-ele-cli" data-inputmask="'mask': '9999-99-99'" id="patDiagDate" name="patDiagDate">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group form-ele-cli">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">폐경 유무</label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="radio" class="flat" name="patMenopauseTF" id="patMenopauseT" value="1" checked/><label for="patMenopauseT" style="cursor:pointer" class="control-label"> &nbsp; 폐경</label> &nbsp; &nbsp; 
												<input type="radio" class="flat" name="patMenopauseTF" id="patMenopauseF" value="0"/><label for="patMenopauseF" style="cursor:pointer"  class="control-label"> &nbsp; 폐경 전</label> &nbsp; &nbsp; 
												<input type="radio" class="flat" name="patMenopauseTF" id="patMenopauseU" value="2"/><label for="patMenopauseU" style="cursor:pointer"  class="control-label"> &nbsp; 알 수 없음</label>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<select id="reasonMenopause" name="reasonMenopause" class="form-control">
													<option value="" disabled selected>폐경 원인</option>
													<option value="1">자연(고령)</option>
													<option value="2">수술</option>
													<option value="3">약물</option>
													<option value="4">기타</option>
												</select>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" id="descMenopauseRes" name="descMenopauseRes" class="form-control form-ele-cli" placeholder="부가정보">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group form-ele-cli">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">흡연력</label>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<select id="patSmokingTF" name="patSmokingTF" class="form-control patRecovery">
													<option value="" disabled selected>흡연여부</option>
													<option value="1">있음(금연포함)</option>
													<option value="2">없음</option>
													<option value="3">알 수 없음</option>
												</select>
											</div>
											<div class="col-md-1 col-sm-1 col-xs-12">
												<select id="smokingFrequency" name="smokingFrequency" class="form-control col-md-2">
													<option value="" disabled selected>주기</option>
													<option value="d">1일</option>
													<option value="w">1주</option>
													<option value="m">1개월</option>
													<option value="e">기타</option>
												</select>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" id="smokingAmount" name="smokingAmount" class="form-control form-ele-cli" placeholder="흡연량(단위:갑)">
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<select id="smokingContinuous" name="smokingContinuous" class="form-control col-md-2">
													<option value="" disabled selected>지속여부</option>
													<option value="1">흡연중</option>
													<option value="2">금연</option>
													<option value="3">기타</option>
												</select>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group" style="background-color:;">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">동반질환</label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<div class="btn-group" data-toggle="buttons">
													<input type="radio" class="flat form-ele-cli" name="patAssoDiseTF" id="patAssoDiseT" value="1"/><label for="patAssoDiseT" style="cursor:pointer" class="control-label"> &nbsp; 있음</label> &nbsp; &nbsp; 													
													<input type="radio" class="flat form-ele-cli" name="patAssoDiseTF" id="patAssoDiseF" value="2" checked/><label for="patAssoDiseF" style="cursor:pointer"	class="control-label"> &nbsp; 없음</label> &nbsp; &nbsp; 
													<input type="radio" class="flat form-ele-cli" name="patAssoDiseTF" id="patAssoDiseU" value="3"/><label for="patAssoDiseU" style="cursor:pointer"	class="control-label"> &nbsp; 모름</label>						
												</div>												
											</div>
											<label class="control-label col-md-2 col-sm-2 col-xs-12">동반질환 수</label>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" id="patNoAssoDise" name="patNoAssoDise" class="form-control form-ele-cli" data-inputmask="'mask':'9종'">
											</div>
										</div>										
										<div class="form-group form-ele-cli" style="background-color:;" id="assoDiseSubDiv">
										</div>									
										
										<div class="ln_solid"></div>
										<div class="form-group" style="background-color:;">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">병용약물</label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<div class="btn-group" data-toggle="buttons">
													<input type="radio" class="flat form-ele-cli" name="patAssoMediTF" id="patAssoMediT" value="1"/><label for="patAssoMediT" style="cursor:pointer" class="control-label"> &nbsp; 있음</label> &nbsp; &nbsp; 													
													<input type="radio" class="flat form-ele-cli" name="patAssoMediTF" id="patAssoMediF" value="2" checked/><label for="patAssoMediF" style="cursor:pointer"	class="control-label"> &nbsp; 없음</label> &nbsp; &nbsp; 
												</div>												
											</div>
											<label class="control-label col-md-2 col-sm-2 col-xs-12">병용약물 수</label>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" id="patNoAssoMedi" name="patNoAssoMedi" class="form-control form-ele-cli" data-inputmask="'mask':'9종'">
											</div>
										</div>										
										<div class="form-group form-ele-cli" style="background-color:;" id="assoMediSubDiv">
										</div>										
																		
										<div class="ln_solid"></div>
										<div class="form-group form-ele-cli">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">골절기왕력</label>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="radio" class="flat" name="patFracHistoryTF" id="fractureT" value="1"/><label for="fractureT" style="cursor:pointer" class="control-label"> &nbsp; 있음</label> &nbsp; &nbsp; 
												<input type="radio" class="flat" name="patFracHistoryTF" id="fractureF" value="0" checked/><label for="fractureF" style="cursor:pointer"  class="control-label"> &nbsp; 없음</label><br />
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-1">
												<input type="text" id="fracPart1" name="fracPart1" class="form-control form-ele-cli" placeholder="요추 골절 횟수">
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" id="fracPart2" name="fracPart2" class="form-control form-ele-cli" placeholder="고관절 골절 횟수">
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="text" id="fracPart3" name="fracPart3" class="form-control form-ele-cli" placeholder="기타부위 골절 횟수">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="form-group form-ele-cli">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">골다공증 치료 상태</label>
											<div class="col-md-10 col-sm-10 col-xs-12">
												<input type="radio" class="flat" name="patTreatState" id="OSState1" value="1" checked /><label for="OSState1" style="cursor:pointer" class="control-label"> &nbsp; 치료중(약물치료)</label> &nbsp; &nbsp; 
												<input type="radio" class="flat" name="patTreatState" id="OSState2" value="2"/><label for="OSState2" style="cursor:pointer" class="control-label"> &nbsp; 증상호전</label> &nbsp; &nbsp; 
												<input type="radio" class="flat" name="patTreatState" id="OSState3" value="3"/><label for="OSState3" style="cursor:pointer" class="control-label"> &nbsp; 회복됨</label> &nbsp; &nbsp; 
												<input type="radio" class="flat" name="patTreatState" id="OSState4" value="4"/><label for="OSState4" style="cursor:pointer" class="control-label"> &nbsp; 변화없음</label>
											</div>
										</div>	
										<div class="ln_solid"></div>
										<div class="form-group form-ele-cli">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">DXA 유무</label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<input type="radio" class="flat" name="patDXATF" id="patDXAT" value="1" checked /><label for="patDXAT" style="cursor:pointer" class="control-label"> &nbsp; 있음</label> &nbsp; &nbsp; 
												<input type="radio" class="flat" name="patDXATF" id="patDXAF" value="0"/><label for="patDXAF" style="cursor:pointer"	class="control-label"> &nbsp; 없음</label>
											</div>
											<label class="control-label col-md-2 col-sm-2 col-xs-12">방사선영상 유무</label>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<input type="radio" class="flat" name="patRadiographyTF" id="patRadiographyT" value="1"/><label for="patRadiographyT" style="cursor:pointer" class="control-label"> &nbsp; 있음</label> &nbsp; &nbsp; 
												<input type="radio" class="flat" name="patRadiographyTF" id="patRadiographyF" value="0" checked /><label for="patRadiographyF" style="cursor:pointer"	class="control-label"> &nbsp; 없음</label>
											</div>
										</div>	
										<div class="ln_solid"></div>
										<div class="form-group">
											<div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-5">
												<button class="btn btn-primary" type="reset" onClick="resetFormClinic();">Reset</button>
												<button type="button" class="btn btn-success" id="submitBtnCli" onClick="submitClinicInfo();">Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
<!-- 임상정보 패널 끝 -->
				
					</div>
				</div>
				<!-- /page content -->

				<!-- footer content -->
				<footer>
					<div class="pull-right">
						경북대학교 의료로봇연구소
					</div>
					<div class="clearfix"></div>
				</footer>
				<!-- /footer content -->
			</div>
		</div>

<div id="preset_assoDisease" style="display:none;" last-id="1">
<div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
<input type="text" id="patAssoDisease" name="patAssoDisease" class="form-control patAssoDisease" placeholder="질환/증후군 명">
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
<input type="text" class="form-control patAssoDiseDate" data-inputmask="'mask': '9999-99-99'" id="patAssoDiseDate" name="patAssoDiseDate" placeholder="진단일">
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
<select id="patRecovery" name="patRecovery" class="form-control patRecovery">
<option value="" disabled selected>완치 여부</option>
<option value="recovering">recovering</option>
<option value="recovered">recovered</option>
<option value="completly recovered">completly recovered</option>
<option value="condition improving">condition improving</option>
<option value="unchanged">unchanged</option>
<option value="inpatient hospitalization">inpatient hospitalization</option>
</select>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
<select id="patRecTreat" name="patRecTreat" class="form-control patRecTreat">
<option value="" disabled selected>해당 처치</option>
<option value="medication">medication</option>
<option value="operation">operation</option>
<option value="post op medication">post op medication</option>
<option value="steady follow up">steady follow up</option>
<option value="none">none</option>
</select>
</div>
</div>


<div id="preset_assoMedicine" style="display:none;" last-id="1">
<div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
<input type="text" id="assoMedicineName" name="assoMedicineName" class="form-control assoMedicineName form-ele-cli" placeholder="약물명">
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
<input type="text" id="assoMedicineCapa" name="assoMedicineCapa" class="form-control assoMedicineCapa form-ele-cli" placeholder="1일 총 투약 용량">
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
<input type="text" id="assoMedicineDur" name="assoMedicineDur" class="form-control assoMedicineDur form-ele-cli" placeholder="투약 기간">
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
<input type="text" id="assoMedicineGoal" name="assoMedicineGoal" class="form-control assoMedicineGoal form-ele-cli" placeholder="투약 목적">
</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="resultRespModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<h3 class="modal-title" id="myModalLabel2">Information</h3>
		</div>
		<div class="modal-body" id="resultResponse">			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>

		</div>
	</div>
</div>

		<!-- jQuery -->
		<script src="./vendors/jquery/dist/jquery.min.js"></script>
	
		<!-- Bootstrap -->
		<script src="./vendors/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src="./vendors/fastclick/lib/fastclick.js"></script>
		<!-- NProgress -->
		<script src="./vendors/nprogress/nprogress.js"></script>
		<!-- bootstrap-progressbar -->
		<script src="./vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
		
		<!-- bootstrap-daterangepicker -->
		<script src="./vendors/moment/min/moment.min.js"></script>
		<script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!-- bootstrap-wysiwyg -->
		<script src="./vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
		<script src="./vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
		<script src="./vendors/google-code-prettify/src/prettify.js"></script>
		<!-- jQuery Tags Input -->
		<script src="./vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
		<!-- Switchery -->
		<script src="./vendors/switchery/dist/switchery.min.js"></script>
		<!-- Select2 -->
		<script src="./vendors/select2/dist/js/select2.full.min.js"></script>
		<!-- Parsley -->
		<script src="./vendors/parsleyjs/dist/parsley.min.js"></script>
		<!-- Autosize -->
		<script src="./vendors/autosize/dist/autosize.min.js"></script>
		<!-- jQuery autocomplete -->
		<script src="./vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
		<!-- iCheck -->	
		<script src="./vendors/iCheck/icheck.min.js"></script>
		<!-- starrr -->	
		<script src="./vendors/starrr/dist/starrr.js"></script>
		<!-- bootstrap-daterangepicker -->
		<script src="./vendors/moment/min/moment.min.js"></script>
		<script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!-- bootstrap-datetimepicker -->		
		<script src="./vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
		<!-- Dropzone.js -->
		<script src="./vendors/dropzone/dist/dropzone.js"></script>
		<!-- jquery.inputmask -->
		<script src="./vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
		<!--tesseract.js -->
		<script src='https://cdn.rawgit.com/naptha/tesseract.js/1.0.10/dist/tesseract.js'></script>
		<!-- Custom Theme Scripts -->	
		<script src="./js/custom.min.js"></script>
	

 <!-- Initialize datetimepicker -->
<script>
	Dropzone.autoDiscover = false;
	//------------------ DXA Spine ------------------------------------
	var dropDxaSpine = $("div#dxaSpine").dropzone({
		url:"./proc_uploadimg_os.php",
		dictDefaultMessage:"DXA Scan Image<br><br>Spine", 
		uploadMultiple:false,
		addRemoveLinks:true,
		maxFiles:1,
		accpetedFiles:".jpg, .dcm",
		success: function(file, response){
			if(response.indexOf("OK:") >= 0){
				OCR(1);
				showAlert("INFO", "<p>이미지가 업로드 되었습니다.</p><p>BMD, T-score, Z-score를 인식합니다.</p><p>잠시만 기다려 주세요.</p>");				
			}else{
				showAlert("ERROR", "<h4>업로드 실패</h4><p>"+response.replace("REJECT:","")+"</p>");				
				this.removeFile(file);
			}
		},
		sending: function(file, xhr, formData){
			formData.append('parts','1');
			formData.append('patSeqID', $("#patSeqID4Dxa").val());
			formData.append('patShotDate', $('#patDXADate').val());
		},
		removedfile: function(file){
			if($('#remReasonDXASpine').val() != "1"){
				$.ajax({
					url:'./proc_removefile_os.php',
					type:'post',
					data:'pnum='+$("#patSeqID4Dxa").val()+'&parts=1&fname='+file.name,
					success: function(resp){
						clearGroup(1);
						showAlert("INFO", "<p>삭제 되었습니다.</p>");										
					}
				});
			}

			var _ref;			
			return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;			
		}
	});
	
	//------------------ DXA RIGHT HIP JOINT ------------------------------------
	var dropApRt = $("div#dxaRtHipJoint").dropzone({
		url:"./proc_uploadimg_os.php",
		dictDefaultMessage:"DXA Scan Image<br><br>Right Hip Joint", 
		uploadMultiple:false,
		addRemoveLinks:true,
		maxFiles:1,
		accpetedFiles:".jpg, .dcm",
		success: function(file, response){
			if(response.indexOf("OK:") >= 0){
				OCR(2);
				showAlert("INFO", "<p>이미지가 업로드 되었습니다.</p><p>BMD, T-score, Z-score를 인식합니다.</p><p>잠시만 기다려 주세요.</p>");				
			}else{
				showAlert("ERROR", "<h4>업로드 실패</h4><p>"+response.replace("REJECT:","")+"</p>");				
				this.removeFile(file);
			}
		},
		sending: function(file, xhr, formData){
			formData.append('parts','2');
			formData.append('patSeqID', $("#patSeqID4Dxa").val());
			formData.append('patShotDate', $('#patDXADate').val());
		},
		removedfile: function(file){
			if($('#remReasonDXARHipJoint').val() != "1"){
				$.ajax({
					url:'./proc_removefile_os.php',
					type:'post',
					data:'pnum='+$("#patSeqID4Dxa").val()+'&parts=2&fname='+file.name,
					success: function(resp){
						clearGroup(2);
						showAlert("INFO", "<p>삭제 되었습니다.</p>");	
					}
				});
			}
			
			var _ref;
			return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;			
		}
	});
	
	//------------------ DXA LEFT HIP JOINT ------------------------------------
	var dropApLt = $("div#dxaLtHipJoint").dropzone({
		url:"./proc_uploadimg_os.php",
		dictDefaultMessage:"DXA Scan Image<br><br>Left Hip Joint", 
		uploadMultiple:false,
		addRemoveLinks:true,
		maxFiles:1,
		accpetedFiles:".jpg, .dcm",
		success: function(file, response){
			if(response.indexOf("OK:") >= 0){
				OCR(3);
				showAlert("INFO", "<p>이미지가 업로드 되었습니다.</p><p>BMD, T-score, Z-score를 인식합니다.</p><p>잠시만 기다려 주세요.</p>");				
			}else{
				showAlert("ERROR", "<h4>업로드 실패</h4><p>"+response.replace("REJECT:","")+"</p>");				
				this.removeFile(file);
			}
		},
		sending: function(file, xhr, formData){
			formData.append('parts','3');
			formData.append('patSeqID', $("#patSeqID4Dxa").val());
			formData.append('patShotDate', $('#patDXADate').val());
		},
		removedfile: function(file){
			if($('#remReasonDXALHipJoint').val() != "1"){
				$.ajax({
					url:'./proc_removefile_os.php',
					type:'post',
					data:'pnum='+$("#patSeqID4Dxa").val()+'&parts=3&fname='+file.name,
					success: function(resp){
						clearGroup(3);
						showAlert("INFO", "<p>삭제 되었습니다.</p>");	
					}
				});
			}
			
			var _ref;
			return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;			
		}
	});
	
	function submitDxaPannel(){
		var params = $("#form_dxaimg").serialize();
		$.ajax({
			url:'proc_submitdxa_os.php',
			type:'post',
			data:params,
			success: function(resp){
				if(resp.indexOf("OK:") >= 0){
					$('.tab-dxa').attr('disabled', true);
					console.log(resp);
					showAlert("CHECK", "<p>등록 되었습니다.</p>");
				}else if(resp.indexOf("ERROR:") >= 0){
					showAlert("ERROR", resp);
				}
			}
		});
	}
	
	function OCR(arg){
		var tmpdir = "./imgworkspace/";
		var prefname = "";
		var noimg = 0;
		
		if($('#patDXADate').val() == ""){
			recognizeDate(tmpdir+"grayblurdate.jpg");
		}
		
		if($('#patChartNumber').val() == ""){
			recognizeNumber(tmpdir+"grayblurpid.jpg");
		}
		
		if($('#patName').val() == ""){
			recognizeName(tmpdir+"grayblurname.jpg");
		}
		
		
		recognizeGender(tmpdir+"grayblurgender.jpg");
		
		
		if($('#patBirthday').val() == ""){
			recognizeDate(tmpdir+"grayblurbirth.jpg");
		}
		
		if($('#patHeight').val() == ""){
			recognizeNumber(tmpdir+"grayblurheight.jpg");
		}		
		
		if($('#patWeight').val() == ""){
			recognizeNumber(tmpdir+"grayblurweight.jpg");
		}
		
		switch(arg){
			case 1:
				prefname = "spval";
				noimg = 10;
				break;
			case 2:
				prefname = "rhval";
				noimg = 4;
				break;
			case 3:
				prefname = "lhval";
				noimg = 4;
				break;
		}		
		
		for(i = 0; i < noimg ; i++){
			for(j = 0; j < 3 ; j++){
				var filename = tmpdir+prefname+i+j+".jpg";
				recognizeNumber(filename);
			}
		}
		
	}
	
	function progressUpdate(packet){
		if('progress' in packet){
			//var progress = document.createElement('progress')
			//progress.value = packet.progress
			//progress.max = 1
			//line.appendChild(progress)
		}

		if(packet.status == 'done'){
			var scoreVal = packet.data.text;				
			
			if(packet.part == "grayblurdate"){
				$('#patDXADate').val(packet.data.text);
				if(packet.data.confidence <= 76){
					$('#patDXADate').css({'background-color':'#ffd2d2'});
				}
			}else if(packet.part == "grayblurpid"){
				$('#patChartNumber').val(packet.data.text);
				if(packet.data.confidence <= 76){
					$('#patChartNumber').css({'background-color':'#ffd2d2'});
				}
			}else if(packet.part == "grayblurname"){
				$('#patName').val(packet.data.text);
				if(packet.data.confidence <= 76){
					$('#patName').css({'background-color':'#ffd2d2'});
				}
			}else if(packet.part == "grayblurgender"){
				var gen = packet.data.text;
				gen = gen.replace(/ /gi, "");
				gen = gen.replace(/\r/g,"");
				gen = gen.replace(/\n/g,"");
				if(gen == "Female"){
					$("#patGenderF").iCheck('check');
				}else{
					$("#patGenderM").iCheck('check');
				}
				//$('#patGender').val(packet.data.text);	////////////////////////////// check
				console.log("gender = ["+gen+"]");
			}else if(packet.part == "grayblurbirth"){
				$('#patBirthday').val(packet.data.text.substr(2, (packet.data.text.length - 1)));
				if(packet.data.confidence <= 76){
					$('#patBirthday').css({'background-color':'#ffd2d2'});
				}
				$('#patBirthday').blur();
			}else if(packet.part == "grayblurheight"){
				$('#patHeight').val(packet.data.text);
				if(packet.data.confidence <= 76){
					$('#patHeight').css({'background-color':'#ffd2d2'});
				}
			}else if(packet.part == "grayblurweight"){
				$('#patWeight').val(packet.data.text);
				if(packet.data.confidence <= 76){
					$('#patWeight').css({'background-color':'#ffd2d2'});
				}
				$('#patWeight').blur();
			}else{					
				scoreVal = scoreVal.replace(/ /gi, "");
				scoreVal = scoreVal.replace(/\r/g,"");
				scoreVal = scoreVal.replace(/\n/g,"");

				if(scoreVal.indexOf(".") < 0){
					if(packet.part.substr(packet.part.length-1,1) == "0"){
						scoreVal = scoreVal.substr(0, 1)+"."+scoreVal.substr(1, scoreVal.length-1);
					}else{
						scoreVal = scoreVal.substr(0, scoreVal.length-1)+"."+scoreVal.substr(scoreVal.length-1,1);
					}
				}
				
				$('#'+packet.part).val(scoreVal);
				if(packet.data.confidence <= 76){
					//console.log("check "+packet.part);
					$('#'+packet.part).css({'background-color':'#ffd2d2'});
				}
			}
			
		}
	}
	
	function recognizeName(file){
		var partname = file.replace("./imgworkspace/","");

		Tesseract.recognize(file, {
			lang: 'kor'		//document.querySelector('#langsel').value,
			//tessedit_char_whitelist:'0123456789/-',
			//user_patterns_file:'./include/dxapattern.txt'
		})
		.progress(function(packet){
			//console.info(packet)
			progressUpdate(packet)

		})
		.then(function(data){
			//console.log(data)
			progressUpdate({ status: 'done', data: data, part: partname.replace(".jpg","")})
		})
	}
	
	function recognizeDate(file){
		var partname = file.replace("./imgworkspace/","");

		Tesseract.recognize(file, {
			lang: 'eng',		//document.querySelector('#langsel').value,
			tessedit_char_whitelist:'0123456789/-',
			user_patterns_file:'./include/dxapattern.txt'
		})
		.progress(function(packet){
			//console.info(packet)
			progressUpdate(packet)

		})
		.then(function(data){
			//console.log(data)
			progressUpdate({ status: 'done', data: data, part: partname.replace(".jpg","")})
		})
	}	
	
	function recognizeGender(file){
		var partname = file.replace("./imgworkspace/","");

		Tesseract.recognize(file, {
			lang: 'eng',		//document.querySelector('#langsel').value,
			tessedit_char_whitelist:'aeFMml',
			user_patterns_file:'./include/dxapattern.txt'
		})
		.progress(function(packet){
			//console.info(packet)
			progressUpdate(packet)

		})
		.then(function(data){
			//console.log(data)
			progressUpdate({ status: 'done', data: data, part: partname.replace(".jpg","")})
		})
	}	

	function recognizeNumber(file){
		var partname = file.replace("./imgworkspace/","");

		Tesseract.recognize(file, {
			lang: 'eng',		//document.querySelector('#langsel').value,
			tessedit_char_whitelist:'.-0123456789',
			user_patterns_file:'./include/dxapattern.txt'
		})
		.progress(function(packet){
			//console.info(packet)
			progressUpdate(packet)

		})
		.then(function(data){
			//console.log(data)
			progressUpdate({ status: 'done', data: data, part: partname.replace(".jpg","")})
		})
	}
	
	function clearGroup(part){
		var idStr = "";
		var row = 0;
		
		$('#patDXADate').val("");
		$('#patDXADate').css({'background-color':'#ffffff'});
		$('#patChartNumber').val("");
		$('#patChartNumber').css({'background-color':'#ffffff'});
		$('#patName').val("");
		$('#patName').css({'background-color':'#ffffff'});
		//$('#patGender').val(packet.data.text);	////////////////////////////// check
		$('#patBirthday').val("");
		$('#patBirthday').css({'background-color':'#ffffff'});
		$('#patHeight').val("");
		$('#patHeight').css({'background-color':'#ffffff'});
		$('#patWeight').val("");
		$('#patWeight').css({'background-color':'#ffffff'});
		$('#pat_Age').val("");
		$('#patBMI').val("");
		
		switch(part){
			case 1:
				idStr = "#spval";
				row = 10;
				break;
			case 2:
				idStr = "#rhval";
				row = 4;
				break;
			case 3:
				idStr = "#lhval";
				row = 4;
				break;
		}
		
		for(i = 0; i < row; i++){
			for(j = 0; j < 3; j++){
				var target = idStr;
				target += i;
				target += j;
				console.log("id = "+idStr);
				$(target).val("");
				$(target).css({'background-color':'#FFFFFF'});
			}
		}
	}
	
	function clearDxaPannel(){
		var objDXASpine = Dropzone.forElement("div#dxaSpine");
		var objDXARtHip = Dropzone.forElement("div#dxaRtHipJoint");
		var objDXALtHip = Dropzone.forElement("div#dxaLtHipJoint");
		
		$('#remReasonDXASpine').val("1");
		$('#remReasonDXARHipJoint').val("1");
		$('#remReasonDXALHipJoint').val("1");
		
		objDXASpine.removeAllFiles();
		objDXARtHip.removeAllFiles();
		objDXALtHip.removeAllFiles();
		
		$('#remReasonDXASpine').val("1");
		$('#remReasonDXARHipJoint').val("1");
		$('#remReasonDXALHipJoint').val("1");
		
		$('.tab-dxa').val('');
		$('.tab-dxa').css({'background-color':'#ffffff'});
		$('.tab-dxa').removeAttr('disabled');
		
		clearGroup(1);
	}
	

	function clearRadioPannel(){
		var objCRSpine = Dropzone.forElement("div#radiographySpine");
		var objCRHip = Dropzone.forElement("div#radiographyHip");
		
		$('#remReasonCRSpine').val("1");
		$('#remReasonCRHip').val("1");
		
		objCRSpine.removeAllFiles();
		objCRHip.removeAllFiles();
		
		$('#remReasonCRSpine').val("1");
		$('#remReasonCRHip').val("1");
	}
	
	$("#patGenderF").on('ifChecked', function(event){
		$("#patMenopauseT").removeAttr('disabled');
		$("#patMenopauseF").removeAttr('disabled');
		$("#patMenopauseU").removeAttr('disabled');
		$("#resonMenopause").removeAttr('disabled');
		$("#descMenopauseRes").removeAttr('disabled');		
	});
	
	$("#patGenderM").on('ifChecked', function(event){
		$("#patMenopauseU").iCheck('check');
	});

	var assoDise = $(':radio[name="patAssoDiseTF"]:checked').val();
	var assoMedi = $(':radio[name="patAssoMedicineTF"]:checked').val();
	var radiographic = $(':radio[name="patRadiographic"]:checked').val();
	var gender = $(':radio[name="patGender"]:checked').val();
	
	if(assoDise != "1"){
		$("#patNoAssoDise").attr('disabled', true);
	}
	
	if(assoMedi != "1"){
		$("#patNoAssoMedi").attr('disabled', true);
	}

		
	if(radiographic != "1"){
		$("#radiographicSub1").hide(100);
	}

	function calcBMI(){
		var patH = document.getElementById("patHeight").value;
		var patW = document.getElementById("patWeight").value;
		if(((patH.indexOf("UK") != -1) || (patH.indexOf("uk") != -1)) || ((patW.indexOf("UK") != -1) || (patW.indexOf("uk") != -1))){
			document.getElementById("patBMI").value = "UK";
		}else{
			var bmi = (patW/((patH/100)*(patH/100)));
			document.getElementById("patBMI").value = bmi.toFixed(2);
		}
	}
	
	function checkEnter(){
		if (event.which == null)
			char= String.fromCharCode(event.keyCode);		// old IE
		else if (event.which != 0 && event.charCode != 0)
			char= String.fromCharCode(event.which);		// All others
	}
	
	function calcAge() { 
		var year=parseInt(new Date().getFullYear()); 
		var age=document.getElementsByName('patBirth'); 
		var ck=parseInt("19"+age[0].value.substr(0,2)); 
		document.getElementById('pat_Age').value = (year-ck)-1; // 우리나라 나이 표시 +1 더함 
	} 

	function submitPatInfo(){
		var seqID = $('#patSeqID').val();
		
		if(seqID == ""){
			showAlert("ERROR", "<p>연구번호는 필수 정보입니다.</p><p>연구번호 입력 후 다시 시도하세요</p>");
		}else{
			$('#patSeqID4Cli').val(seqID);
			$('#patSeqID4Rad').val(seqID);			
			var params = $("#form_pat").serialize();
			$.ajax({
				url:'./proc_submitpat_os.php',
				type:'post',
				data:params,
				success:function(res){
					if(res.indexOf('OK:') >= 0){
						showAlert("INFO", "정상 입력되었습니다.");
						$('.form-ele-pat').css({'background-color':''});
						$('.form-ele-pat').attr("readonly", true);
					}else{
						if(res.indexOf('ERROR:') >= 0){
							document.getElementById("resultResponse").innerHTML = "<h4>승인 실패</h4><br>".res;
						}else{
							document.getElementById("resultResponse").innerHTML = "<h4>승인 실패</h4><p>삭제할 수 없습니다.</p>";
						}
						$('#resultRespModal').modal('show');
					}				
				}
			});
		}		
	}

	function resetFormPat(){
		$('.form-ele-pat').attr("readonly", false);
	}

	function submitClinicInfo(){
		var seqID = $('#patSeqID').val();
		
		if(seqID == ""){
			showAlert("ERROR", "<p>연구번호는 필수 정보입니다.</p><p>연구번호 입력 후 다시 시도하세요</p>");
		}else{
			document.getElementById("patSeqID4Cli").value = seqID;
			var params = $("#form_clinic").serialize();

			$.ajax({
				url:'./proc_submitcli_os.php',
				type:'post',
				data:params,
				success:function(res){
					if(res.indexOf('OK:') >= 0){
						showAlert("INFO", "정상 입력되었습니다.");
						$('.form-ele-cli').attr("readonly", true);
						$('.form-ele-cli input').attr("disabled", "disabled");
						$('.form-ele-cli select').attr("disabled", "disabled");
					}else{
						if(res.indexOf('ERROR:') >= 0){
							document.getElementById("resultResponse").innerHTML = "<h4>승인 실패</h4><br>".res;
						}else{
							document.getElementById("resultResponse").innerHTML = "<h4>승인 실패</h4><p>삭제할 수 없습니다.</p>";
						}
						$('#resultRespModal').modal('show');
					}				
				}
			});
		}
	}

	function resetFormClinic(){
		$('#patAssoDiseF').iCheck('check');
		$('#patAssoMediF').iCheck('check');
		$('.form-ele-cli').attr("readonly", false);
		$('.form-ele-cli input').removeAttr("disabled");
		$('.form-ele-cli select').removeAttr("disabled");
	}
	
$('#patSeqID4Dxa').keyup(function(){
	var idStr = $(this).val();
		
	$("#patSeqID").val(idStr);
	$("#patSeqID4Cli").val(idStr);
	
	if(idStr.replace(/_/g,"").length == 7){
		checkExist();
	}

});
	
$("#patNoAssoDise").keyup(function() {
	if($('#submitTypeCli').val() != "2"){
		document.getElementById('assoDiseSubDiv').innerHTML = "";
		var pre_set = document.getElementById('preset_assoDisease');
		var fieldid = Number(pre_set.getAttribute('last-id'));
		pre_set.setAttribute('last-id', "1" );
		for(i = 0; i < parseInt($(this).val()) ; i++){
			addAssoDiseaseSubDiv();
			$("#patAssoDiseDate"+(i+1)).inputmask("9999-99-99");
		}
		$('#patAssoDisease1').focus();
	}
});

function addAssoDiseaseSubDiv() {
    // 원본 찾아서 pre_set으로 저장.
    var pre_set = document.getElementById('preset_assoDisease');
    // last-id 속성에서 필드ID르 쓸값 찾고
    var fieldid = Number(pre_set.getAttribute('last-id'));
    // 다음에 필드ID가 중복되지 않도록 1 증가.
    pre_set.setAttribute('last-id', fieldid + 1 );

    // 복사할 div 엘리먼트 생성
    var div = document.createElement('div');
    // 내용 복사
    div.innerHTML = pre_set.innerHTML;
	div.setAttribute('class', "form-group");
	
	//alert(div.innerHTML);
	
    // selection_content 영역에 내용 변경.
	
	var assoDiseaseName = div.getElementsByClassName('patAssoDisease')[0];
	assoDiseaseName.setAttribute('name', "patAssoDisease"+fieldid);
	assoDiseaseName.setAttribute('id', "patAssoDisease"+fieldid);	
	assoDiseaseName.setAttribute('placeholder', fieldid+"질환/증후군 명");
	
	var assoDiseDate = div.getElementsByClassName('patAssoDiseDate')[0];
	assoDiseDate.setAttribute('id', "patAssoDiseDate"+fieldid);	
	assoDiseDate.setAttribute('name', "patAssoDiseDate"+fieldid);
	
	var assoRecovery = div.getElementsByClassName('patRecovery')[0];
	assoRecovery.setAttribute('id', "patRecovery"+fieldid);	
	assoRecovery.setAttribute('name', "patRecovery"+fieldid);
	
	var assoRecTreat = div.getElementsByClassName('patRecTreat')[0];
	assoRecTreat.setAttribute('id', "patRecTreat"+fieldid);
	assoRecTreat.setAttribute('name', "patRecTreat"+fieldid);

    // delete_box에 삭제할 fieldid 정보 건네기
//    var deleteBox = div.getElementsByClassName('delete_box')[0];
    // target이라는 속성에 삭제할 div id 저장
  //  deleteBox.setAttribute('target',div.id);
    // #field에 복사한 div 추가.
	document.getElementById('assoDiseSubDiv').appendChild(div);
}

$("#patNoAssoMedi").keyup(function() {	
	if($('#submitTypeCli').val() != "2"){
		document.getElementById('assoMediSubDiv').innerHTML = "";
		var pre_set = document.getElementById('preset_assoMedicine');
		var fieldid = Number(pre_set.getAttribute('last-id'));
		pre_set.setAttribute('last-id', "1" );
		for(i = 0; i < parseInt($(this).val()) ; i++){
			addAssoMedicineSubDiv();
			
		}
		$('#assoMedicineName1').focus();
	}
});


function addAssoMedicineSubDiv() {
    // 원본 찾아서 pre_set으로 저장.
    var pre_set = document.getElementById('preset_assoMedicine');
    // last-id 속성에서 필드ID르 쓸값 찾고
    var fieldid = Number(pre_set.getAttribute('last-id'));
    // 다음에 필드ID가 중복되지 않도록 1 증가.
    pre_set.setAttribute('last-id', fieldid + 1 );

    // 복사할 div 엘리먼트 생성
    var div = document.createElement('div');
    // 내용 복사
    div.innerHTML = pre_set.innerHTML;
	div.setAttribute('class', "form-group");
	
	var assoDiseaseName = div.getElementsByClassName('assoMedicineName')[0];
	assoDiseaseName.setAttribute('id', "assoMedicineName"+fieldid);
	assoDiseaseName.setAttribute('name', "assoMedicineName"+fieldid);
	assoDiseaseName.setAttribute('placeholder', fieldid+"약물명");
	
	var assoDiseDate = div.getElementsByClassName('assoMedicineCapa')[0];
	assoDiseDate.setAttribute('name', "assoMedicineCapa"+fieldid);
	assoDiseDate.setAttribute('id', "assoMedicineCapa"+fieldid);
	
	var assoRecovery = div.getElementsByClassName('assoMedicineDur')[0];
	assoRecovery.setAttribute('name', "assoMedicineDur"+fieldid);
	assoRecovery.setAttribute('id', "assoMedicineDur"+fieldid);
	
	var assoRecTreat = div.getElementsByClassName('assoMedicineGoal')[0];
	assoRecTreat.setAttribute('name', "assoMedicineGoal"+fieldid);
	assoRecTreat.setAttribute('id', "assoMedicineGoal"+fieldid);

    document.getElementById('assoMediSubDiv').appendChild(div);
}
  
	
	
$('#patRadiographicT').on('ifChecked', function(event){
	$("#radiographicSub1").show(100);
	$("#patRadiographicDate").focus();
});

$('#patRadiographicF').on('ifChecked', function(event){
	$("#radiographicSub1").hide(100);
});

$('#patAssoMediT').on('ifChecked', function(event){
	$("#patNoAssoMedi").attr('disabled', false);
	$("#patNoAssoMedi").focus();
});

$('#patMenopauseT').on('ifChecked', function(event){
	$('#reasonMenopause').removeAttr('disabled');
	$('#descMenopauseRes').removeAttr('disabled');
});

$('#patMenopauseF').on('ifChecked', function(event){
	$('#reasonMenopause').attr('disabled', true);
	$('#descMenopauseRes').attr('disabled', true);
});

$('#patMenopauseU').on('ifChecked', function(event){
	$('#reasonMenopause').attr('disabled', true);
	$('#descMenopauseRes').attr('disabled', true);
});

$('#patAssoMediF').on('ifChecked', function(event){
	document.getElementById('assoMediSubDiv').innerHTML = "";
	$("#patNoAssoMedi").val('');
	$("#patNoAssoMedi").attr('disabled', true);
});	
	
$('#patAssoDiseT').on('ifChecked', function(event){
	$("#patNoAssoDise").attr('disabled', false);
	$("#patNoAssoDise").focus();
});

$('#patAssoDiseF').on('ifChecked', function(event){
	document.getElementById('assoDiseSubDiv').innerHTML = "";
	$("#patNoAssoDise").val('');
	$("#patNoAssoDise").attr('disabled', true);
});

$('#patAssoDiseU').on('ifChecked', function(event){
	document.getElementById('assoDiseSubDiv').innerHTML = "";
	$("#patNoAssoDise").val('');
	$("#patNoAssoDise").attr('disabled', true);
});

function showAlert(type, str){
	var icon;
	if(type == "ERROR"){
		icon = "<i class=\"fa fa-ban\" style=\"color:orangered;\"></i>";
		title = "ERROR";
	}else if(type == "INFO"){ // if(type == "INFO")
		icon = "<i class=\"fa fa-info-circle\" style=\"color:navy;\"></i>";
		title = " INFORMATION";
	}else if(type == "CHECK"){
		icon = "<i class=\"fa fa-check-circle-o\" style=\"color:#90d133;\"></i>";
		title = " INFORMATION";
	}else if(type == "WARN"){
		icon = "<i class=\"fa fa-exclamation-triangle\" style=\"color:orange;\"></i>";
		title = " INFORMATION";
	}
	
	document.getElementById("myModalLabel2").innerHTML = icon +" &nbsp;"+title;
	document.getElementById("resultResponse").innerHTML = str;
	$('#resultRespModal').modal('show');
}

function initialSubmitBtns(){
	$("#submitBtnPat").removeClass("btn-warning");
	$("#submitBtnPat").addClass("btn-success");
	$("#submitBtnPat").html("Submit");
	$("#submitBtnCli").removeClass("btn-warning");
	$("#submitBtnCli").addClass("btn-success");
	$("#submitBtnCli").html("Submit");
	$("#submitBtnDXA").removeClass("btn-warning");
	$("#submitBtnDXA").addClass("btn-success");
	$("#submitBtnDXA").html("Submit");
}

function changeSubmitBtns(){
	$("#submitBtnPat").addClass("btn-warning");
	$("#submitBtnPat").removeClass("btn-success");
	$("#submitBtnPat").html("Modify");
	$("#submitBtnCli").addClass("btn-warning");
	$("#submitBtnCli").removeClass("btn-success");
	$("#submitBtnCli").html("Modify");
	$("#submitBtnDXA").addClass("btn-warning");
	$("#submitBtnDXA").removeClass("btn-success");
	$("#submitBtnDXA").html("Modify");
}

function checkExist(){
	var seqID = $('#patSeqID4Dxa').val();
	//$('#form_clinic')[0].reset();
	clearDxaPannel();
	$('#form_pat')[0].reset();
	resetFormPat();
	resetFormClinic();
	$('#patSeqID').val(seqID);	
	$('#patDiagnosis').val("OS");
	$('#patDiagDate').val('');
	$('#submitTypeDXA').val("0");
	$('#submitTypePat').val("0");
	$('#submitTypeCli').val("0");
	initialSubmitBtns();
	
	if(seqID != ""){
		$.ajax({
			url:'./proc_checkexist_os.php',
			type:'post',
			data:'pid='+seqID,
			success:function(res){
				if(res.indexOf("EXIST:") >= 0){
					$('#submitTypeDXA').val("1"); //수정모드(0:등록, 1:수정)
					$('#submitTypePat').val("1"); //수정모드(0:등록, 1:수정)
					$('#submitTypeCli').val("2"); //Key up 이벤트 방지
					$('#patSeqID').attr("readonly", true);
					//$('#patSeqID4Dxa').attr("readonly", true);
					changeSubmitBtns();
					parseDetail(res.replace("EXIST:",""));
					showAlert("WARN", "<P>이미 등록된 연구번호 입니다.</P><p>수정 모드로 전환합니다.</p>");
				}else if(res.indexOf("EMPTY:") >= 0){
					showAlert("CHECK", "<P>등록되지 않은 연구번호입니다.</P><P>나머지 정보를 입력하신 후 submit 하세요.</P>");					
				}else if(res.indexOf("FAIL") >= 0){
					showAlert("ERROR", "<P>정보를 검색할 수 없습니다.</P><P>서버에 문제가 있을 수도 있습니다.<br>관리자에 연라바랍니다.</P>");
				}else{
					
				}				
			}
		});	
	}
}

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

function parseBirth(birthStr){
	var cnt = birthStr.indexOf("-");
	var retVal;

	if(cnt > 0){
		var strArr = birthStr.split("-");
		if(strArr[0].length == 4){
			retVal = birthStr.substr(2,8);
		}
	}
	return retVal;
}

function parseDetail(paramJson){
	var objDetail = JSON.parse(paramJson);
	var assoDiseCnt = 1;
	var assoMediCnt = 1;

	if(objDetail.assetTF == 1){
		showAlert("ERROR","<P>등록된 환자이며,</P><P>이미 평가가 진행되어 정보를 수정할 수 없는 환자입니다.</P>");
	}else{
		$('#patChartNumber').val(objDetail.chartnum);
		$('#patName').val(objDetail.name);
		$('#patInitial').val(objDetail.initial);

		if(objDetail.gender == "F"){
			$("#patGenderF").iCheck('check');
		}else{
			$("#patGenderM").iCheck('check');
		}
	
		$('#patBirthday').val(parseBirth(objDetail.birth));
		$('#pat_Age').val(objDetail.age);

		$('#patHeight').val(objDetail.height);
		$('#patWeight').val(objDetail.weight);
		$('#patBMI').val(objDetail.bmi);

		$('#patDiagnosis').val(objDetail.diagnosis);
		if(!objDetail.diagdate){
			
		}else{
			$('#patDiagDate').val(objDetail.diagdate.replace(/-UK/gi,"-00"));
		}
		
		if(!objDetail.assoDise){
			assoDiseCnt = 0;
		}else{
			if(objDetail.assoDise == 2){
				$("#patAssoDiseF").iCheck('check');
			}else if(objDetail.assoDise == 3){
				$("#patAssoDiseU").iCheck('check');
			}else{
				$("#patAssoDiseT").iCheck('check');
				
				$("#patNoAssoDise").val(objDetail.assoDise.length+'종');
				document.getElementById('assoDiseSubDiv').innerHTML = "";
				var dise_preset = document.getElementById('preset_assoDisease');
				var dist_fieldid = Number(dise_preset.getAttribute('last-id'));
				dise_preset.setAttribute('last-id', "1" );
				for(i = 0; i < objDetail.assoDise.length ; i++){
					addAssoDiseaseSubDiv();
				}
			}	
			assoDiseCnt = 1;			
		}

		if(!objDetail.assoMedi){
			assoMediCnt = 0;
		}else{
			if(objDetail.assoMedi == 2){
				$("#patAssoMediF").iCheck('check');
			}else{
				$("#patAssoMediT").iCheck('check');
				$("#patNoAssoMedi").val(objDetail.assoMedi.length+'종');
				document.getElementById('assoMediSubDiv').innerHTML = "";
				var medi_preset = document.getElementById('preset_assoMedicine');
				var medi_fieldid = Number(medi_preset.getAttribute('last-id'));
				medi_preset.setAttribute('last-id', "1" );
				for(i = 0; i < objDetail.assoMedi.length ; i++){
					addAssoMedicineSubDiv();
				}
			}
			assoMediCnt = 1;
		}
		
		if(assoDiseCnt == 1){
			for(i = 0; i < objDetail.assoDise.length ; i++){
				var tmp = objDetail.assoDise[i];
				$('#patAssoDisease'+(i+1)).val(tmp.assoDiag);
				$('#patAssoDiseDate'+(i+1)).val(tmp.assoDiagDate);
				if(tmp.assoState != ""){
					$('#patRecovery'+(i+1)+' option[value=\''+tmp.assoState+'\']').attr('selected', 'selected');
				}
				if(tmp.assoTreat != ""){
					if(tmp.assoTreat == "steady f/u"){
						$('#patRecTreat'+(i+1)+' option[value=\''+tmp.assoTreat+'\']').attr('selected', 'selected');	
					}else{
						$('#patRecTreat'+(i+1)+' option[value=\''+tmp.assoTreat+'\']').attr('selected', 'selected');
					}
				}
			}
		}
		
		if(assoMediCnt == 1){
			for(i = 0; i < objDetail.assoMedi.length ; i++){
				var tmp = objDetail.assoMedi[i];
				$('#assoMedicineName'+(i+1)).val(tmp.medicine);
				$('#assoMedicineCapa'+(i+1)).val(tmp.capa);
				$('#assoMedicineDur'+(i+1)).val(tmp.duration);
				$('#assoMedicineGoal'+(i+1)).val(tmp.goal);
			}
		}
		
		$("#submitTypeCli").val("1"); //수정모드, key up 이벤트 활성화(0:등록, 1:수정, 2:key up 이벤트 비활성화(불러온 값 설정용))
		
		if(!objDetail.fracHistory){
		}else{
			if(objDetail.fracHistory == "0"){
				$("#fractureF").iCheck('check');
			}else{		
				$("#fractureT").iCheck('check');
				if(objDetail.fracHistory.indexOf(",") > 0){
					var fracArr = objDetail.fracHistory.split(",");
					console.log("Frac Array Length : "+fracArr.length);
					for(i = 0; i < fracArr.length ; i++){
						var frac = fracArr[i].replace(")","").split("(");
						$("#fracPart"+frac[0]).val(frac[1]);
					}
				}else{
					var frac = objDetail.fracHistory.replace(")","").split("(");
					$("#fracPart"+frac[0]).val(frac[0]);
				}
			}
		}
		
		if(parseInt(objDetail.OStreat) > 4){
			
		}else{
			$("#OSState"+objDetail.OStreat).iCheck('check');
		}
		
		if((objDetail.dxaLHip != "none")&&(objDetail.dxaRHip != "none")&&(objDetail.dxaSpine != "none")){
			var dirStr = "../ktl/uploadimages/OS/";
			for(i = 0; i < objDetail.radiography.length ; i++){
				var tmp = objDetail.radiography[i];
				if($("#patDXADate").val() == ""){
					$("#patDXADate").val(tmp.date);
				}
				
				if(tmp.type == "1"){					
					var L1 = objDetail.dxaSpine.l1.split("|");
					var L2 = objDetail.dxaSpine.l2.split("|");
					var L3 = objDetail.dxaSpine.l3.split("|");
					var L4 = objDetail.dxaSpine.l4.split("|");
					var L1L2 = objDetail.dxaSpine.l1l2.split("|");
					var L1L3 = objDetail.dxaSpine.l1l3.split("|");
					var L1L4 = objDetail.dxaSpine.l1l4.split("|");
					var L2L3 = objDetail.dxaSpine.l2l3.split("|");
					var L2L4 = objDetail.dxaSpine.l2l4.split("|");
					var L3L4 = objDetail.dxaSpine.l3l4.split("|");
					
					var totalArray = new Array(L1, L2, L3, L4, L1L2, L1L3, L1L4, L2L3, L2L4, L3L4);
					
					for(j = 0 ; j < 10 ; j++){
						for(k = 0 ; k < 3 ; k++){
							$("#spval"+j+""+k).val(totalArray[j][k]);
						} 	
					} 
				}
				
				if(tmp.type == "2"){					
					var neck = objDetail.dxaRHip.neck.split("|");
					var upperNeck = objDetail.dxaRHip.upneck.split("|");
					var troch = objDetail.dxaRHip.troch.split("|");
					var total = objDetail.dxaRHip.total.split("|");
					
					var totalArray = new Array(neck, upperNeck, troch, total);
					
					for(j = 0 ; j < 4 ; j++){
						for(k = 0 ; k < 3 ; k++){
							$("#rhval"+j+""+k).val(totalArray[j][k]);
						} 	
					} 
				}
				
				if(tmp.type == "3"){					
					var neck = objDetail.dxaLHip.neck.split("|");
					var upperNeck = objDetail.dxaLHip.upneck.split("|");
					var troch = objDetail.dxaLHip.troch.split("|");
					var total = objDetail.dxaLHip.total.split("|");
					
					var totalArray = new Array(neck, upperNeck, troch, total);
					
					for(j = 0 ; j < 4 ; j++){
						for(k = 0 ; k < 3 ; k++){
							$("#lhval"+j+""+k).val(totalArray[j][k]);
						} 	
					} 
				}
				
				/*
				var mockFile = { name: tmp.fname, size: tmp.fsize };

				$("#patRadioDate").val(tmp.date);
				
				if(tmp.type == "1"){		
					dropWholeAp.emit("addedfile", mockFile);
					dropWholeAp.emit("thumbnail", mockFile, dirStr+"/wholeAP/"+tmp.fname);
					dropWholeAp.emit("complete", mockFile);
					dropWholeAp.files.push( mockFile );
				}
				if(tmp.type == "2"){
					dropBothKnee.emit("addedfile", mockFile);
					dropBothKnee.emit("thumbnail", mockFile, dirStr+"/bothknee/"+tmp.fname);
					dropBothKnee.emit("complete", mockFile);
					dropBothKnee.files.push( mockFile );
				}
				if(tmp.type == "3"){
					dropApRt.emit("addedfile", mockFile);
					dropApRt.emit("thumbnail", mockFile, dirStr+"/AP_RT/"+tmp.fname);
					dropApRt.emit("complete", mockFile);
					dropApRt.files.push( mockFile );
				}
				if(tmp.type == "4"){
					dropApLt.emit("addedfile", mockFile);
					dropApLt.emit("thumbnail", mockFile, dirStr+"/AP_LT/"+tmp.fname);
					dropApLt.emit("complete", mockFile);
					dropApLt.files.push( mockFile );
				}
				if(tmp.type == "5"){
					dropLatRt.emit("addedfile", mockFile);
					dropLatRt.emit("thumbnail", mockFile, dirStr+"/LAT_RT/"+tmp.fname);
					dropLatRt.emit("complete", mockFile);
					dropLatRt.files.push( mockFile );
				}
				if(tmp.type == "6"){
					dropLatLt.emit("addedfile", mockFile);
					dropLatLt.emit("thumbnail", mockFile, dirStr+"/LAT_LT/"+tmp.fname);
					dropLatLt.emit("complete", mockFile);
					dropLatLt.files.push( mockFile );
				}
				if(tmp.type == "7"){
					dropSkyline.emit("addedfile", mockFile);
					dropSkyline.emit("thumbnail", mockFile, dirStr+"/skyline/"+tmp.fname);
					dropSkyline.emit("complete", mockFile);
					dropSkyline.files.push( mockFile );
				}
				*/

			}
		}
		
		if(!objDetail.smoking){
			
		}else{

			if((objDetail.smoking == "2")||(objDetail.smoking == "3")){
				$('#patSmokingTF option[value='+objDetail.smoking+']').attr('selected', 'selected');
			}else{
				var tmp = objDetail.smoking;
				$('#patSmokingTF option[value=1]').attr('selected', 'selected');
				$('#smokingFrequency option[value='+tmp.freq+']').attr('selected', 'selected');
				$('#smokingAmount').val(tmp.amount);
				$('#smokingContinuous option[value='+tmp.continuous+']').attr('selected', 'selected');
			}
		}
		
		
		if(!objDetail.menopause){
			
		}else{
			console.log("meno = "+objDetail.menopause);
			if(objDetail.menopause == "0"){
				$('#patMenopauseF').iCheck('check');
			}else if((objDetail.menopause == "2")||(objDetail.menopause == "9")){
				$('#patMenopauseU').iCheck('check');
			}else{
				$("#patMenopauseT").iCheck('check');
				console.log("reason = "+objDetail.menopause.reason);
				$('#reasonMenopause option[value='+objDetail.menopause.reason+']').attr('selected', 'selected');
				$('#descMenopauseRes').val(objDetail.menopause.description);
			}
		}
	}
}
</script>	
	</body>
</html>
