plugin.tx_automaketemplate_pi1 {
    # Read the template file:
  content = FILE
  content.file = {$rwConf.templates}{$rwConf.templatefile}

    # Here we define which elements in the HTML that 
    # should be wrapped in subpart-comments:
  elements {
    BODY.all = 1
    BODY.all.subpartMarker = DOCUMENT_BODY
    HEAD.all = 1
    HEAD.all.subpartMarker = DOCUMENT_HEADER
    HEAD.rmTagSections = title
   ID.all = 1
   SPAN.all = 1
   TD.all = 1
   DIV.all = 1
   UL.all = 1   
  }
    # Prefix all relative paths with this value:
  relPathPrefix = {$rwConf.templates}

}



temp.mainTemplate = TEMPLATE
temp.mainTemplate {
  template =< plugin.tx_automaketemplate_pi1
  workOnSubpart = DOCUMENT_BODY
subparts {
    kotak-content < content
    linkQ < menu.breadcrumb     
    frame-photo < frame-photo     
    nav1 < menu.top
    linkQ < menu.breadcrumb
    nav < menu
    #about < menu.secondlevel 
    #slide < slideshow
    #BOMenu < BOMenu
    JNMenu < JNMenu
    footerTop < menu.footer
    navigationContent < lib.contentleft
    mainContent < lib.content
    presentedBy < presentedBy
    hotel-login < hotel-login   
    hotel-login-backoffice < hotel-login-backoffice 
    res-middle1 < search-hotel
    city-favorite < city-favorite
    city-favorite-list < city-favorite-list
    res-middle1 < search-hotel-list
    res-middle < res-middle
    slideshow < slider1
    box-visit-middle < box-visit-middle
    box-detail-hotel < box-detail-hotel
    showMap < showMap
    
    #HOME 
    banner < slideshow
    imgBusinnes < packetImgBusinnes
    imgTravel < packetImgTravel
    imgVIP < packetImgVIP
    bank-top < bank-top
    testimoni < testimoni  
    logout < logout
    take-tour < takeatour
    # backend admin
    navigation < navigationAdmin
    
    #ADMIN-HOTEL
    #navigation < navigation
    welcome-to-hotel < welcome-to-hotel
    logo_core < logo_core
    }
marks {
    hostname < hostname
    #hostname < {$rwConf.hostname}    
    }
}

temp.headTemplate = TEMPLATE
temp.headTemplate {
  template =< plugin.tx_automaketemplate_pi1
  workOnSubpart = DOCUMENT_HEADER
}

page = PAGE
page.typeNum = 0

page.20 < temp.mainTemplate

page.headerData.1 = HTML
page.headerData.20  < temp.headTemplate