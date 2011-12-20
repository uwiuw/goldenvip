menu.secondlevel = HMENU
menu.secondlevel {
	entryLevel = 2
	1 = TMENU
	1 {
	    wrap = <ul class="about">|</ul>
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