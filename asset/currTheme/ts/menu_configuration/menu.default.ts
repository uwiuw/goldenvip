menu = HMENU
menu {
    special= directory
    special.value = {$rwConf.mainmenu}		
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
[globalVar = LIT:1 = {$rwConf.dropdownmenu}]
menu = HMENU
menu {
    special= directory
    special.value = {$rwConf.mainmenu}		
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
               		wrapItemAndSub = <li class="atas">|</li> |*| <li>|</li> |*| <li class="bawah">|</li>
               		
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
	2 < .1
    2.wrap = <ul class="about">|</ul>
    2.NO.wrapItemAndSub=<li style="margin-top: 12px;">|</li> |*| <li class="tengah">|</li> |*| <li class="bawah">|</li>

	3 < .1
    3.wrap = <ul>|</ul>
}
[global]

# TOP MENU FOR BACKOFFICE

BOMenu = HMENU
BOMenu.special = list
BOMenu.special.value = 83
BOMenu.1 = TMENU
BOMenu.1.NO {
    linkWrap = |
    ATagParams = class="back-office"
}

# TOP MENU FOR JOIN NOW
JNMenu = HMENU
JNMenu.special = list
JNMenu.special.value = 52
JNMenu.1 = TMENU
JNMenu.1.NO {
    linkWrap = |
    ATagParams = class="join-now"
}