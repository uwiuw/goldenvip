# Insert the news plugin in single-view mode instead of normal page content if a news article is requested
[globalVar = GP:tx_ttnews|tt_news > 0] && [globalVar = TSFE:id = {$plugin.tt_news.singlePid}]

lib.content < plugin.tt_news
lib.content {
	# First empty the code field and then set it to single-view
	code >
	code = SINGLE
	templateFile = {$rwConf.extensiontemplates}tt_news/tx_ttnews_pi1_template.html
    #templateFile = {$rwConf.extensiontemplates}about-us-story.html
}
[else]

# In all other cases, get the content of the middle column and add it to the 'content' part
lib.content < styles.content.get

[global]



slideshow = COA
slideshow {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 2
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=1
            languageField = sys_language_uid
            begin= 0
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
content = COA
content {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = this
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 0
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}


packetImgBusinnes = COA
packetImgBusinnes {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 2
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=2
            languageField = sys_language_uid
            begin= 0
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
packetImgTravel = COA
packetImgTravel {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 2
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=2
            languageField = sys_language_uid
            begin= 1
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
packetImgVIP = COA
packetImgVIP {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 2
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=2
            languageField = sys_language_uid
            begin= 2
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
bank-top = COA
bank-top {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 2
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=3
            languageField = sys_language_uid
            begin= 1
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
testimoni = COA
testimoni {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 2
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
footer = HMENU
footer {
	special = directory
    special.value = 26
	1 = TMENU
	1 {
	    wrap = |
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
content-atas = COA
content-atas {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 35
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
content-bawah = COA
content-bawah {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 35
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 1
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}

frame-photo = COA
frame-photo {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = this
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=2
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
#[PIDinRootline != 81]
presentedBy = COA
presentedBy {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 2
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=3
            languageField = sys_language_uid
            begin= 0
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
#[end]

hotel-login = COA
hotel-login {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 60
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
hotel-login-backoffice = COA
hotel-login-backoffice {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 83
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
menu-admin = HMENU
menu-admin {
    special= directory
    special.value = 63
	1 = TMENU
	1 {
		wrap = |
		expAll = 1
		noBlur = 1
		NO = 1
		NO {
			ATagTitle {
				field = title
				fieldRequired = nav_title
			}
               		wrapItemAndSub = <li>|</li> |*| <li>|</li> |*| <li>|</li>
               		
               		# HTML-encode special characters according to the PHP-function htmlSpecialChars
               		stdWrap.htmlSpecialChars = 1
		}

		ACT < .NO
		ACT {
			ATagParams = class="active"
		}
		CUR < .NO
		CUR {
			ATagParams = class="active"
		}
	}

}
kotak-shop-left = COA
kotak-shop-left {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 81
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
about-over-view = COA
about-over-view {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 36
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
kotak-shop-right = COA
kotak-shop-right {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 81
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=1
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}

hostname = TEXT
hostname.value(
    {$rwConf.hostname}
)

#Halaman Back Office ##

logout-backoffice = COA
logout-backoffice{
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 87
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
search-hotel = COA
search-hotel {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 93
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=1
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
city-favorite = COA
city-favorite {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 93
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}

city-favorite-list = COA
city-favorite-list {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 97
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
box-detail-hotel = COA
box-detail-hotel {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 97
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}

show-ctn-member = COA
show-ctn-member {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = this
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
res-middle = COA
res-middle {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 93
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=1
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
slider1 = COA
slider1 {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 93
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
box-visit-middle = COA
box-visit-middle {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 93
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=2
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
showMap = COA
showMap {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 99
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=0
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
logout = COA
logout {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = this
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=1
            languageField = sys_language_uid
            begin= 0
            #max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}

takeatour = COA
takeatour {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 2
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=1
            languageField = sys_language_uid
            begin= 1
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
welcome-to-hotel = COA
welcome-to-hotel {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 101
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=2
            languageField = sys_language_uid
            begin= 0
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
logo_core = COA
logo_core {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = 101
            orderBy = sorting
      
            # Kies kolom: 0,1,2,3,...
            where = colpos=2
            languageField = sys_language_uid
            begin= 1
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
