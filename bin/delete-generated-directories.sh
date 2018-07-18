#!/bin/bash
if [ -d /data/docker/volumes/magento_appdata/_data ]; then
    echo Deleting generated content...
else
    echo "ERROR: No such directory: /data/docker/volumes/magento_appdata/_data"
    echo "Bailing out."
    exit 1
fi

cd /data/docker/volumes/magento_appdata/_data
rm -rf pub/static/* var/cache/* var/di/* var/generation/* var/page_cache/*

echo All done.
