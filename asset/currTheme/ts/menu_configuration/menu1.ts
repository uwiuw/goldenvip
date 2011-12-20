temp.layermenu2 = HMENU
temp.layermenu2 {
   entryLevel = 0
1 = TMENU
1 {
expAll = 1
wrap = <div class="cssmenuWrap"><ul id="nav2">|</ul></div>
noBlur = 1
NO = 1
NO.wrapItemAndSub = <li class="menuparent level1">|</li>

ACT = 1
ACT.wrapItemAndSub = <li class="li_act">|</li>
IFSUB = 1
IFSUB.wrapItemAndSub = <li class="menuparent">|</li>
IFSUB.ATagParams = class="ifsubarrow"

ACTIFSUB = 1
ACTIFSUB.wrapItemAndSub = <li class="li_act menuparent">|</li> *[additional
submenu code should be added here: <table>... </table>]*
ACTIFSUB.ATagParams = class="ifsubarrow"

}
2 < .1
        2 {
#no 'static' submenu on levels 2 and 3 wrap = <ul>|</ul> ACT = 1
ACT.wrapItemAndSub = <li class="li_act">|</li> ACTIFSUB = 1
ACTIFSUB.wrapItemAndSub = <li class="li_act menuparent">|</li>
ACTIFSUB.ATagParams = class="ifsubarrow" }

3 < .2
}
