({
	appDir:"./../",
	baseUrl:"js",
	dir:"../build",
	mainConfigFile:"weibo.js",
	optimize:"none",
	paths:{
		jquery:'empty:',
		"backbone":"libs/backbone-min",
		"underscore":"libs/underscore-min",
		"backbone.localStorage":"libs/backbone.localstorage",
		"bootstrap":"empty:",
		WB:'empty:'
	},
	optimizeCss:"standard",
	modules:[{
		name:"weibo"
	}]
})