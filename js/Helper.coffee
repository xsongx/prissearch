define ->
	Helper =
		version:1.0
		getQueryString:(name,url)->
			reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)")
			querystring = if arguments[1]? then arguments[1].substr(arguments[1].indexOf("?")) else window.location.search
			#querystring = arguments[1]?arguments[1].substr(arguments[1].indexOf("?")):window.location.search
			r = querystring.substr(1).match(reg)
			return unescape(r[2]) if r?
			return null
		getFileContent:(fileInput,callback)->
			# NOTE: fileInput should be a DOM object ,if jQuery,please use $('xxx').get(0) instead
			if fileInput.files and fileInput.files.length>0 and fileInput.files[0].size>0
				file = fileInput.files[0]
				reader = new FileReader()
				reader.readAsText(file)
				#define event
				reader.onloadend = (evt) ->
					if evt.target.readyState is FileReader.DONE
						callback evt.target.result
					else
						console.log "something went wrong!!"
	return Helper