<?php
namespace Deployer;

require 'recipe/zend_framework.php';

// Project name
set('application', 'YAWIK');

// Project repository
set('repository', 'git@gitlab.cross-solution.de:aviation/yawik.git');

// Shared files/dirs between deploys
add('shared_files', [
    'test/sandbox/public/.htaccess',
    'test/sandbox/public/robots.txt',
]);

add('shared_dirs', [
    'test/sandbox/var/log',
    'test/sandbox/var/cache',
    'test/sandbox/config/autoload',
    'test/sandbox/public/static',	// used by eg. organization logos
]);

// Writable dirs by web server
add('writable_dirs', [
    'test/sandbox/var/cache',
    'test/sandbox/var/log',
    'test/sandbox/public/static',
]);

set('default_stage', 'prod');

// Hosts

host('aviation.yawik.org')
    ->user('yawik')
    ->stage('prod')
    ->multiplexing(false)
    ->set('deploy_path', '/home/yawik/production')
    ->set('writableusesudo', true);

host('staging.aviation.yawik.org')
    ->user('yawik')
    ->stage('staging')
    ->multiplexing(false)
    ->set('deploy_path', '/home/yawik/staging')
    ->set('writableusesudo', true);


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// restart nodeserver
after('cleanup', 'restart');

task('restart', '
    sudo /bin/systemctl restart php7.4-fpm.service;
');
