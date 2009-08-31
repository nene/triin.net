#!/usr/bin/env bash

# Get list of local PHP files + .htaccess
# + a list of files in kujundus/ and style/
ls *.php > deploy-list
echo .htaccess >> deploy-list
find kujundus/ -name '*?.?*' >> deploy-list
find style/ -name '*?.?*' >> deploy-list

# then create a similar list of files in remote
cd remote/
ls *.php > ../remote-list
echo .htaccess >> ../remote-list
find kujundus/ -name '*?.?*' >> ../remote-list
find style/ -name '*?.?*' >> ../remote-list
cd ..

# sort both lists
sort deploy-list > deploy-list~
mv deploy-list~ deploy-list
sort remote-list > remote-list~
mv remote-list~ remote-list

# All files in deploy-list need to be put into server,
# so we do that:
for file in $(cat deploy-list); do
    echo cp $file remote/$file
    cp $file remote/$file
done

# Files that are in server but not in deploy list,
# need to be removed from server.  So we do that too.
#
# Command for finding set complemet was found from here:
# http://www.catonmat.net/blog/set-operations-in-unix-shell/
to_remove=$(comm -23 <(sort remote-list) <(sort deploy-list))
for file in $to_remove; do
    echo rm remote/$file
    rm remote/$file
done

# clean up
rm deploy-list remote-list


