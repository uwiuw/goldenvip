menu-backoffice = HMENU
menu-backoffice {
    special= directory
    special.value = 95
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
    2.wrap = <ul>|</ul>
    2.NO.wrapItemAndSub=<li style="margin-top: 12px;">|</li> |*| <li class="tengah">|</li> |*| <li class="bawah">|</li>

	3 < .1
    3.wrap = <ul>|</ul>

}