#!/bin/sh
#
rsync -avhu --update --exclude 'include/Database/DatabaseConnect.inc.php' \
--exclude 'include/API/staticDB.php' \
--exclude '.git' \
. root@engineer.da.co.th:/home/engineer/law/
echo "-------------------"
echo "  Up to Server OK"
echo "-------------------"