#!/bin/bash

DATETIME=$(date +%d-%m-%Y-%H:%M:%S)
git add .
git commit -m "$DATETIME"
git push -u origin main
echo "===========================
Git Push Finished ${DATETIME}
===========================
"
