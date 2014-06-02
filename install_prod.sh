#!/bin/bash
cap deploy:setup
cap deploy:cold
cap symfony:doctrine:database:drop
cap symfony:doctrine:database:create
scp -r web/uploads root@job.fresh.local:/var/www/jobmanager/current/web/
mysql -h job.fresh.local -u root -pqqq jobmanager < /home/pi/jobmanager.sql