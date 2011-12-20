temp.teammenu= HMENU
temp.teammenu.special = directory
temp.teammenu.includeNotInMenu =1
temp.teammenu.special.value = 24
temp.teammenu.1 = TMENU
temp.teammenu.1 {
expAll = 1
  ACT = 1
  ACTIFSUB=1
  ACTIFSUB.stdWrap.htmlSpecialChars = 1
  ACTIFSUB.wrapItemAndSub = <li class="leftactive">|</li>
}
temp.teammenu.1.wrap = |
temp.teammenu.1.NO {
wrapItemAndSub = <li>|</li>
 }
temp.teammenu.1.CUR =1
temp.teammenu.1.CUR{
 wrapItemAndSub = <li class="list-home">|</li>
}
temp.teammenu.1.ACT =1
temp.teammenu.1.ACT {
 wrapItemAndSub = <li class="list-home">|</li>
}

# WEBSITE ELEMENTs END
# Main TEMPLATE cObject for the BODY
temp.mainTemplate = TEMPLATE
temp.mainTemplate {
    # Feeding the content from the Auto-parser to the TEMPLATE cObject:
  template =< plugin.tx_automaketemplate_pi1
    # Select only the content between the <body>-tags
  workOnSubpart = DOCUMENT_BODY
# TYPO3 ELEMENTS 2 HTML ELEMENTS START

subparts.nav < temp.teammenu

# TYPO3 ELEMENTS 2 HTML ELEMENTS END
}
# Main TEMPLATE cObject for the HEAD
temp.headTemplate = TEMPLATE
temp.headTemplate {
    # Feeding the content from the Auto-parser to the TEMPLATE cObject:
  template =< plugin.tx_automaketemplate_pi1
    # Select only the content between the <head>-tags
  workOnSubpart = DOCUMENT_HEADER
}
# Default PAGE object:
page = PAGE
page.typeNum = 0
# Copying the content from TEMPLATE for <body>-section:
page.20 < temp.mainTemplate
# Copying the content from TEMPLATE for <head>-section:
page.headerData.20 = HTML
page.headerData.20  < temp.headTemplate

temp.teammenu= HMENU
temp.teammenu.special = directory
temp.teammenu.includeNotInMenu =1
temp.teammenu.special.value = 3
temp.teammenu.1 = TMENU
temp.teammenu.1 {
expAll = 1
  ACT = 1
  ACTIFSUB=1
  ACTIFSUB.stdWrap.htmlSpecialChars = 1
  ACTIFSUB.wrapItemAndSub = <li class="leftactive">|</li>
}
temp.teammenu.1.wrap = |
temp.teammenu.1.NO {
wrapItemAndSub = <li>|</li>
 }
temp.teammenu.1.CUR =1
temp.teammenu.1.CUR{
 wrapItemAndSub = <li class="list-home">|<ul></ul></li>
}
temp.teammenu.1.ACT =1
temp.teammenu.1.ACT {
 wrapItemAndSub = <li class="list-home">|</li>
}

# WEBSITE ELEMENTs END
# Main TEMPLATE cObject for the BODY
temp.mainTemplate = TEMPLATE
temp.mainTemplate {
    # Feeding the content from the Auto-parser to the TEMPLATE cObject:
  template =< plugin.tx_automaketemplate_pi1
    # Select only the content between the <body>-tags
  workOnSubpart = DOCUMENT_BODY
# TYPO3 ELEMENTS 2 HTML ELEMENTS START

subparts.about < temp.teammenu

# TYPO3 ELEMENTS 2 HTML ELEMENTS END
}
# Main TEMPLATE cObject for the HEAD
temp.headTemplate = TEMPLATE
temp.headTemplate {
    # Feeding the content from the Auto-parser to the TEMPLATE cObject:
  template =< plugin.tx_automaketemplate_pi1
    # Select only the content between the <head>-tags
  workOnSubpart = DOCUMENT_HEADER
}
# Default PAGE object:
page = PAGE
page.typeNum = 0
# Copying the content from TEMPLATE for <body>-section:
page.20 < temp.mainTemplate
# Copying the content from TEMPLATE for <head>-section:
page.headerData.20 = HTML
page.headerData.20  < temp.headTemplate

menu.secondlevel = HMENU
menu.secondlevel {
	entryLevel = 2
	1 = TMENU
	1 {
	    wrap = <ul>|</ul>
		NO {
			wrapItemAndSub = <li>|</li>
		}
		ACT {
			ATagParams >
			wrapItemAndSub = <li class="active">|</li>
		}
		CUR {
			ATagParams >
			wrapItemAndSub = <li class="selected">|</li>
		}
	}
	2 < .1
	3 < .1
}