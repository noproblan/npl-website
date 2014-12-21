#!/bin/bash
# Usage: deploy_prod.ssh USER@HOST
echo "Updating files on server"
ssh -t $1 "
    cd /srv/noproblan.ch
    git pull --rebase --stat
    sudo chown -R www-data:www-data .
"
