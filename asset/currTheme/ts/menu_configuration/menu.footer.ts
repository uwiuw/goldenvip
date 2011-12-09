menu.footer = HMENU
menu.footer {
	special = directory
    special.value = 26
	1 = TMENU
	1 {
	    wrap = <ul>|</ul>
		NO {
			wrapItemAndSub = <li>|</li> |*| <li>|</li> |*| <li class="last">|</li>            
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