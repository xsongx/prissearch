<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>微博SPAM专用页</title>
	<meta name="description" content="">
	<meta name="author" content="Boychenney">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

	<!-- CSS
	  ==================================================-->
	 <link rel="stylesheet" href="css/main.css"> 
	 <script data-main="js/spam_reg" src="js/require.js"></script>

</head>
<body>


	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->

	<div class="container">
		<div class="row">
			<div class="span12">
				<h1 class="remove-bottom" style="margin-top: 20px">微博SPAM探测</h1>
				<h5>Date:2013.3.18</h5>
				<h5>Author:Boychenney</h5>				
				<hr />
			<div class="row">
			    <div class="span9">		    	
				    	<form id="codeForm" class="form-inline">
				    		<legend>1、导入用户ID</legend>
							<p>	
								<div class="fileupload fileupload-new" data-provides="fileupload">
								  <div class="input-append"  rel="tooltip" data-placement="left" title="显示所选的文件名">
								    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span id="btn_selfile" class="btn btn-file"><span class="fileupload-new">选择</span><span id="btn_chfile" class="fileupload-exists">更改</span><input id="userfile" type="file" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload" id="btn_rmfile" rel="tooltip" data-placement="right" title="移除所选文件">移除</a>
								  </div>
								</div>						
									
									<button id="btn_loadfile" class="btn">加载文件内容</button>							
							</p>
							<p>
			    				<textarea rows="3" rel="tooltip" data-placement="bottom" title="用户名单"></textarea>			    			
				    		</p>
				    		<p>当前第<span class="label label-info"><span id="currentIndex">0</span>&nbsp;/&nbsp;<span id="totalIndex">0</span></span>位&nbsp;&nbsp;
				    			<span id="no_next_user" class="label label-warning" style="display:none">已到最后一位用户了！！</span>
				    			<span id="no_pre_user" class="label label-warning" style="display:none">现已是第一位用户了！！</span>
				    		</p>

				    		<div class="progress progress-info progress-striped">
							  <div id="bar_user_progress" class="bar" style="width: 40%;"></div>
							</div>			    		
				    	</form>
				    	
				    
				    <form class="form-inline" id="getTokenForm">
				    	<legend>2、简略视图</legend>
						
					    <div id="weiboinfo" style="max-width:100%;min-width:100px;min-height:100px;margin: 0 auto 10px;">
						    <p>
					    		<lable class="info_title">当前的URL：</lable>
					    		<span id="weibo_url">http://weibo.com/u/<span id="userid"></span></span>
								&nbsp;&nbsp;&nbsp;
					    		<span>
					    			<lable class="info_title">用户名：</lable><span id="uname"></span>
					    		</span>
					    	</p>
							
							<p>用户ID：<span id="uid"></span></p>
							<p>关注数：<span id="follow"></span></p>
							<p>粉丝数：<span id="fans"></span></p>
							<p>微博数：<span id="weibo"></span></p>
							<p>个人描述：<span id="describe"></span></p>
							<p>标签：<span id="userlabel"></span></p>
							<p>位于：<span id="geo"></span></p>
							<p>就读于：<span id="edu"></span></p>
							<p>最近微博内容:<span id="weiboContent"></span></p>
					    </div>
				    </form>				    			    			    
				</div>
				
				<div class="span3">
					<form class="form-inline" id="getTokenForm" data-spy="affix" data-offset-top="0">
				    	<legend>3、SPAM类型</legend>

				    	<button class="btn btn-warning" type="button" id="btn_pre_user" rel="tooltip" data-placement="top" title="返回到上一个用户">&lt;&lt;&nbsp;上一个用户</button>
						<br/>
						<br/>
						<!-- (p>button.btn[type="button" rel="tooltip" data-placement="rigth" title=""])*3 -->
						<div class="well" style="max-width:100%; argin: 0 auto 10px;">            
							<p><button class="btn btn-success btn-block btn-large btn_next_user" type="button" rel="tooltip" data-placement="top" alt="norm" title="正常用户，不是SPAM">正常用户</button></p>
							<p><button class="btn btn-info btn-block btn-large btn_next_user" type="button" rel="tooltip" data-placement="top" alt="not_sure" title="暂时无法确定用户类型">不确定</button></p>
							<p><button class="btn btn-inverse btn-block btn-large btn_next_user" type="button" rel="tooltip" data-placement="top" alt="not_exist" title="该用户可能已遭新浪封杀了">用户ID不存在</button></p>
						</div>
						<p style="max-width: 100%; margin: 0 auto 10px;">
							<b class="text-error">SPAM：</b>
							<button class="btn btn-danger btn_next_user" type="button" rel="tooltip" data-placement="bottom" alt="spam_ad" title="可能是广告">广告</button>
							<button class="btn btn-danger btn_next_user" type="button" rel="tooltip" data-placement="bottom" alt="spam_junk_info" title="可能是无用信息">xxxx</button>
							<button class="btn btn-danger btn_next_user" type="button" rel="tooltip" data-placement="bottom" alt="spam_dead_fans" title="可能是僵尸粉">xxxxx</button>
						</p>
						
						<button class="btn btn-success" type="button" id="btn_show_result" rel="tooltip" data-placement="left" title="查看标注结果">查看结果</button>
				    </form>	

				</div>



			</div>
		 
		
			</div>
		</div>
	</div><!-- container -->
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">标注结果</h3>
  </div>
  <div class="modal-body">
    <table id="judge_result" class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>用户ID</th>
                  <th>标注结果</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
      </table>
      <div id="mypagination"></div>
  </div>

  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <button id='btn_save_result' class="btn btn-primary">保存</button>
  </div>
</div>
<!-- End Document
================================================== -->
</body>
</html> 