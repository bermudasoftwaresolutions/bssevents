# Git global setup
git config --global user.name "Milos Velevski"

git config --global user.email "milos.velevski@raspberry.rs"

# Create a new repository
git clone ssh://git@gitlab.dock02.bermuda-software.ch:2222/dev/typo3/bss-shop/bss_shop_provider.git

cd bss_shop_provider

touch README.md

git add README.md

git commit -m "add README"

git push -u origin master

# Push an existing folder

cd existing_folder

git init

git remote add origin ssh://git@gitlab.dock02.bermuda-software.ch:2222/dev/typo3/bss-shop/bss_shop_provider.git

git add .

git commit -m "Initial commit"

git push -u origin master

# Push an existing Git repository
cd existing_repo

git remote rename origin old-origin

git remote add origin ssh://git@gitlab.dock02.bermuda-software.ch:2222/dev/typo3/bss-shop/bss_shop_provider.git

git push -u origin --all

git push -u origin --tags