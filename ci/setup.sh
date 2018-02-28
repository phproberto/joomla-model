#!/bin/bash

# Clone current joomla & install composer there
git clone --depth 1 https://github.com/joomla/joomla-cms.git /tmp/joomla-cms
composer install -d /tmp/joomla-cms

# Install joomla-model testing composer dependencies
composer install --prefer-dist --no-interaction --no-progress

# Install joomla-model library composer dependencies
composer install -d ./extensions/libraries/phproberto_joomla_model

# Copy CI gulp config (with cloned joomla path) to the build folder
cp ./ci/gulp-config.ci.json ./build/gulp-config.json

# Install npm packages in the build folder
cd ./build
npm install -g gulp 
npm install

# Copy joomla extensions to the cloned joomla site
gulp copy 
cd ..
