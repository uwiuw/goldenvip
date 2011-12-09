config {
	// Administrator settings
	admPanel		= {$rwConf.adminPanel}
	debug			= {$rwConf.debug}
	
	doctype			= xhtml_trans

	// Character sets
	renderCharset 		= utf-8
	metaCharset 		= utf-8

	// Cache settings
        cache_period		= 43200
	sendCacheHeaders	= 1
        
	// URL Settings
	tx_realurl_enable       = 1
	simulateStaticDocuments = 0

	// Language Settings
	uniqueLinkVars          = 1
	linkVars                = L
    sys_language_uid 	    = 0
	sys_language_overlay 	= 1
	sys_language_mode 	= content_fallback
	language         	= en
	locale_all       	= en_US.UTF-8
	htmlTag_langKey  	= en
	
	// Link settings
	# # absRefPrefix            = /
	prefixLocalAnchors      = all
	
	// Remove targets from links
	intTarget =
	extTarget =

	// Indexed Search
	index_enable		= 1
	index_externals		= 1

	// Code cleaning
	disablePrefixComment	= 1
	
	// Move default CSS and JS to external file	
	removeDefaultJS      	= external
	inlineStyle2TempFile 	= 1

	// Protect mail addresses from spamming
	spamProtectEmailAddresses = -3
	spamProtectEmailAddresses_atSubst = @<span style="display:none;">remove-this.</span>

	// Comment in the <head> tag
	headerComment (
	
	)
}

# Set baseURL setting for http or https
config.baseURL ={$rwConf.baseUrl}

// Condition to switch the doctype and xml prologue
[browser = msie] && [version = <7]
config {
	doctypeSwitch = 1
}
[global]

// Condition to set language according to L POST/GET variable
[globalVar = GP:L = 1]
config {
	htmlTag_langKey = id
	sys_language_uid = 1
	language = id
	locale_all = id_ID
}
[global]
