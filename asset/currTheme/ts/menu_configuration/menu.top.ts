menu.top = HMENU
menu.top {
	special = directory
    special.value = {$rwConf.topmenu}
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



navigation = HMENU
navigation {
	special = directory
    special.value = 63
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


