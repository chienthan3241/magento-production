**To Make a working copy from this repo**  

1. dump the actual database from live:
```
ssh to dev.devgmt.com (login with root)
cd /data/www/htdocs/live
sh dbdump.sh -f
git add var/db_dump_full.sql
git commit -m "generate full db dump"
git push
```

2. on local computer: 
```
mkdir magento-production
cd magento-production
git clone git@git.devgmt.com:mct/magento-production.git .
scp dein_username@dev.devgmt.com:/data/www/htdocs/live/app/etc/env.php ./app/etc/
scp dein_username@dev.devgmt.com:/data/www/htdocs/live/app/etc/config.php ./app/etc/
```
create a mysql database (for example with phpmyadmin)  
change connection string in env.php
```
scp dein_username@dev.devgmt.com:/data/www/htdocs/live/dbdump.sh .
scp dein_username@dev.devgmt.com:/data/www/htdocs/live/dbimport.sh .
```
change PATH for variable MYSQL_PATH in this both bash script files  
import db von live
```
sh dbimport.sh -f
composer install
(maybe need git config core.filemode false to set gitdiff not show diff on file mode)  
# copy media folder from live to local
rsync -aHPi dein_username@dev.devgmt.com:/data/www/htdocs/live/pub/media/ pub/media/
```
**important:**  
after run import full from master repo, need to change sercure and unsecure base_url in the table core_config_data in mysql:  
It can be manuell changed or:  
```
UPDATE `core_config_data` SET `value` = 'http://localhost:PORT' WHERE `core_config_data`.`path` = 'web/unsecure/base_url' or `core_config_data`.`path` = 'web/secure/base_url';
```

3. about dbdump and dbimport  

**dbdump.sh:**
This script is used to dump Magento2 databases by reading the env.php file and parsing the DB credentials. Three mode:
+ -d: dump details each row for git diff (some not important tables will be ignored, using --insert-ignore option from mysqldump).  
That means when you import this dump to mysql, the current db stand will not be changed, only the new things will appended(for example: new catagories, new product etc..).  
Use case when live.devgmt.com want to import from developer  
dump_file location: DUMP_FILE="./var/db_dump_compress.sql"
+ -i: dump details each row for git diff (some not important tables will be ignored, using --replace option from mysqldump).
That means when you import this dump to mysql, the current db stand will be updated(old product name, old product describle etc...) and the new things will appended(for example: new catagories, new product etc..).  
Use case: when live.devgmt.com want to update from developer and vice versa (developer muss know exactly what will be changed in the db after updated)  
dump_file location: DUMP_FILE_REPLACE="./var/db_dump_update.sql"
+ -f: dump full of database  
Use case: developer want to make fresh db copy from live  
dump_file location: DUMP_FILE_FULL="./var/db_dump_full.sql" 
 
**dbimport.sh:**
This script is used to import from dumped file from above script by reading the env.php file and parsing the DB credentials.  
Three mode:
+ -a: import from dump (not delete any data but only append the changes from developer --insert-ignore mode from dump)  
Use case when live.devgmt.com want to import from developer  
dump_file location: DUMP_FILE="./var/db_dump_compress.sql"
+ -r: import from dump (data will be update the changes from developer --replace mode from dump)  
Use case: when live.devgmt.com want to update from developer and vice versa (developer muss know exactly what will be changed in the db after updated).    
dump_file location: DUMP_FILE_REPLACE="./var/db_dump_update.sql"
+ -f: full import of database  
Use case: developer want to make fresh db copy from live  
dump_file location: DUMP_FILE_FULL="./var/db_dump_full.sql"