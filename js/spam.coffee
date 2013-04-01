require.config
			baseUrl: "/prissearch/js/" 
			paths:
				'jquery':"./libs/jquery"
				'backbone':"./libs/backbone-min"
				'underscore':"./libs/underscore-min"								
				'bootstrap':'./../css/bootstrap/js/bootstrap.min'
				'Helper':'./Helper'
				'simplePagination':'./plugins/jquery.simplePagination'		
			shim:
				'backbone':
					deps:["underscore","jquery"]
					exports:"Backbone"
				'underscore':
					exports:"_"
				'bootstrap':
					deps:['jquery']
					exports:"jquery"
				'simplePagination':
					deps:['jquery']
					exports:"jquery"

require ['jquery','backbone',"Helper",'bootstrap','simplePagination'],($,Backbone,Helper)->
		$ ->
			#更新提示信息
			updateInfo = (index)->
				localStorage.setItem "currentIndex",index
				$("#currentIndex").text parseInt(index)+1
				$("#userid").text localStorage.getItem("x"+index)
				$("#bar_user_progress").width (parseInt(index)+1)*100/(parseInt(localStorage.getItem('userNum')))+"%"

			#分页函数
			updatePaginate = (pageNum,itemsOnPage)->
				$('#judge_result>tbody').html('')
				for i in [(pageNum-1)*itemsOnPage..(pageNum*itemsOnPage-1)]
					userid = localStorage.getItem("x"+i)
					$("#judge_result>tbody").append "<tr>
					<td>"+(i+1)+"</td>
					<td>"+userid+"</td>
					<td>"+localStorage.getItem(userid)+"</td>
					</tr>"

			#从后台获取截取的微博主页
			fetchFromSina = (cIndex)->
				$("#weiboinfo").removeClass('bounceInLeft').addClass('animated bounceOutLeft') #隐藏主页内容
				uid = localStorage.getItem("x"+cIndex) #获取用户ID
				#去除隐性的回车符
				#uid = uid.replace(/\s?/g, "")
				$("iframe").attr("src","login_sina.php?userid="+uid)
				$("#weiboinfo").removeClass('bounceOutLeft').addClass('animated bounceInLeft')

			#获取本地存储
			userNum = localStorage.getItem("userNum") ? 0
			cIndex = localStorage.getItem("currentIndex") ? 0
			itemsOnPage = 5 #每页上显示数目
			$('#totalIndex').text userNum
			if localStorage.getItem("x"+cIndex)
				#更新页面信息
				updateInfo cIndex 
				#载入时获取主页
				fetchFromSina cIndex

			#按钮的alt属性，并保存到本地
			$(".btn_next_user").each (key,value)->
				localStorage.setItem $(this).attr('alt'),key
				#console.log $(this).attr('alt')+"=>"+localStorage.getItem($(this).attr('alt'))
			

			#显示提示语
			$("[rel=tooltip]").tooltip()


			#加载文件内容
			$("#btn_loadfile").click (e)->
				e.preventDefault()
				console.log "start loading..."				
				Helper.getFileContent($('#userfile').get(0),(result)->
					$('#no_next_user').hide()
					$('textarea').html(result)
					idArr = result.split("\r\n") #注意应当用“\r\n”而不是“\n”
					userNum = idArr.length
					localStorage.setItem "x"+i,userid for userid,i in idArr
					localStorage.setItem "currentIndex",0
					localStorage.setItem "userNum",userNum
					$('#totalIndex').text userNum					
					cIndex = 0					
					updateInfo 0
					fetchFromSina 0 #获取第一个人的资料													
				)

			#移除文件时，自动清空textarea的内容
			$("#btn_rmfile,#btn_chfile").click (e)->
				cIndex = 0
				updateInfo 0				
				console.log "clear files."
				$('#no_next_user').hide()				
				localStorage.clear()
				$('textarea').html('')
				$("#currentIndex").text 0
				$('#totalIndex').text 0
				$("#bar_user_progress").width 0
				$("#weiboinfo").removeClass('bounceInLeft').addClass('animated bounceOutLeft')

			#下一个用户按钮
			$(".btn_next_user").click (e)->
				$('#no_pre_user').hide()
				localStorage.setItem localStorage.getItem("x"+cIndex),$(this).attr('alt')								
				if cIndex < parseInt(localStorage.getItem "userNum")-1					
					console.log ">>>next user"
					cIndex = parseInt(cIndex) + 1					
					updateInfo cIndex
					fetchFromSina cIndex					
				else
					$('#no_next_user').removeClass('bounce')					
					$('#no_next_user').show().addClass('animated bounce')
					console.log "没有下一位用户了:"+cIndex

			#上一个用户按钮
			$("#btn_pre_user").click (e)->
				console.log ">>>previous user"
				$('#no_next_user').hide()					
				if cIndex > 0
					cIndex = parseInt(cIndex) - 1
					updateInfo cIndex
					fetchFromSina cIndex
				else
					$('#no_pre_user').removeClass('bounce')					
					$('#no_pre_user').show().addClass('animated bounce')
					console.log "现已是第一位用户了"

			#显示结果按钮
			$("#btn_show_result").click (e)->
				$('#myModal').modal("show")
				$("#mypagination").pagination
			        items: userNum
			        itemsOnPage: itemsOnPage
			        cssStyle: 'light-theme'
			        prevText:'<<'
			        nextText:'>>'
			        onPageClick:(pageNum,e)->
			        	updatePaginate(pageNum,itemsOnPage)

				updatePaginate(1,itemsOnPage)
			
			#弹出对话框的保存按钮
			$("#btn_save_result").click (e)->
				#利用Ajax直接将localStorage保存到服务器上
				#先合并数据（自动去重）
				spam_result = {}
				for i in [0..localStorage.getItem("userNum")-1]
					console.log i
					userid = localStorage.getItem("x"+i)
					spam_result[userid]=localStorage.getItem(userid)
				
				$.ajax
					type:"POST"
					url:"save_result.php"
					dataType:"json"
					data:{result:JSON.stringify(spam_result)}
					success:(data)->
						console.log data
						$(".spam_info").remove() #清除查看链接
						if(data.isSaved)
							$("<a class='spam_info' href='result.txt' target='_blank'>点击查看</a>").insertAfter("#btn_show_result")
						else
							$("<span class='spam_info label label-warning'>Sorry,no data</span>").insertAfter("#btn_show_result")
						#同时关闭弹出框
						$('#myModal').modal('hide')

			#点击任何按钮都#清除查看链接
			$(".btn").click (e)->
				$(".spam_info").remove()




