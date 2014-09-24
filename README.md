# Add sublime shortcut to open file on mac
   sudo ln -s /Applications/Sublime\ Text\ 2.app/Contents/SharedSupport/bin/subl /usr/local/bin/sublime

   FOR SYMFONY
   See .vagrant_bootstrap/custom.sh
   Add to /etc/hosts "192.168.100.10 symfony-gobelins.dev"

   OR cp /etc/hosts /etc/hosts.bak && echo "192.168.100.10 symfony-gobelins.dev" >> /etc/hosts.bak && mv /etc/hosts.bak /etc/hosts