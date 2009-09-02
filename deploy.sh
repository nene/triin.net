#!/usr/bin/env bash
#
# Copy files over to server
# Only copy files that aren't already there.
#
# TODO: Removing files that aren't needed any more
#
ncftpput -f conf.deploy -z -R public_html *.php .htaccess kujundus style



