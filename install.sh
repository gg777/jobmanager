#!/bin/bash
cap deploy:setup
cap deploy:cold
cap symfony:doctrine:database:drop
cap symfony:doctrine:database:create
scp -r web/uploads root@job.fresh.local:/var/www/sfblog/current/web/
scp /home/pi/jobmanager.sql root@job.fresh.local:/home/gerard/
mysql -h job.fresh.local -u root -pqqq jobmanager < /home/gerard/jobmanager.sql