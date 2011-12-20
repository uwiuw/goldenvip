lib.contentleft = COA
lib.contentleft.wrap = <div class="module">|</div>
lib.contentleft {
	20 < styles.content.getLeft
}

[globalVar = LIT:1 = {$rwConf.leftdefault}]
lib.contentleft = COA
lib.contentleft.wrap = <div class="module">|</div>
lib.contentleft {
	20 < styles.content.getLeft
    20.select.pidInList = 2
}
[global]