# BACK OFFICE
home-office = COA
home-office {
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
genelogy-cepat = COA
genelogy-cepat {
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
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
cycle = COA
cycle {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = this
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
info-binary = COA
info-binary {
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
            max= 1
        }
    #renderObj.stdWrap.wrap =<div id="MainContent">|</div>
    }
}
direct-sponsored = COA
direct-sponsored {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = this
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
show-message = COA
show-message {
    10 = CONTENT
    10 {
        table = tt_content
        select {
            pidInList = this
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