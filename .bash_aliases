alias aliases='xdg-open ~/.bash_aliases'
alias createFile='clear && touch'
alias note='xdg-open '
alias x='exit'
alias bashmem='source ~/.bashrc'
alias lsla='clear && ls -la'

alias httpdConf='clear && sudo nano /opt/lampp/etc/httpd.conf'

alias apacheRestart='clear && cd /opt/lampp/bin/ && sudo ./apachectl restart'

alias lamppUp='clear && sudo /opt/lampp/lampp start'
alias lamppDown='clear && sudo /opt/lampp/lampp stop'
alias lamppRestart='clear && sudo /opt/lampp/lampp restart'
alias lamppReload='clear && sudo /opt/lampp/lampp reload'
alias lamppStatus='clear && sudo /opt/lampp/lampp status'

alias wwwDir='clear && cd /opt/lampp/htdocs/WWW/ && lsla'
alias dockerDir='clear && cd /opt/lampp/htdocs/WWW/Docker/ && lsla'
alias laravelDir='clear && cd /opt/lampp/htdocs/WWW/LARAVEL && lsla'

alias gitStatus='clear && git branch && git status'
alias gitAdd='clear && git add .'
alias gitCommit='clear && git commit -m'

alias composerAddProd='clear && composer require'
alias composerAddDev='clear && composer require --dev'
alias composerCreateProject='clear && composer create-project laravel/laravel'

