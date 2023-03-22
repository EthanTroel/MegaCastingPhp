<?php
namespace Deployer;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/vendor/autoload.php';

require 'recipe/symfony.php';
set('env', [
    'SYMFONY_ENV' => 'prod',
    'APP_ENV' => 'prod'
]);

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');


// Project name
set('application', 'app');
set('http_user', 'www-data');
set('writable_mode', 'chmod');
set('bin/console', '{{release_path}}/bin/console');
set('branch', 'main');

// Hosts
host($_ENV['DEPLOYER_REPO_HOST'])
    ->setRemoteUser('adminlocal')
    ->setHostname($_ENV['DEPLOYER_REPO_HOSTNAME'])
    ->setPort($_ENV['DEPLOYER_REPO_PORT'])
    ->set('deploy_path', '/var/www/symfony');

set('keep_releases', 3);

// Project repository
set('repository', $_ENV['DEPLOYER_REPO_URL']);

// [Optional] Allocate tty for git clone. Default value is false.
//set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
//add('writable_dirs', []);
set('allow_anonymous_stats', false);
set('composer_options', " --verbose --prefer-dist --no-progress --no-interaction --no-dev  --optimize-autoloader");

// Tasks
task('set:env', function () {
    upload(dirname(__FILE__).'/.env.prod.local', '{{release_path}}/.env.local');
});
after('deploy:update_code', 'set:env');

task('build_assets', function () {
    //set('release_path',dirname(__FILE__));
    runLocally('rm -Rf '.dirname(__FILE__)."/public/build");
    runLocally('yarn build');
})->once();
after('deploy:update_code', 'build_assets');


task('upload_assets', function () {
    upload(dirname(__FILE__).'/public/build', '{{release_path}}/public');
});
after('deploy:cache:clear', 'upload_assets');

//task('build:npm', function () {
//    run('cd {{release_path}} && npm install --omit=dev');
//});
//after('deploy:update_code', 'build:npm');

// Migrate database before symlink new release.
before('deploy:symlink', 'database:migrate');


task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:cache:clear',
    'deploy:publish'
])->desc('DÃ©ploiement de Megacasting');

// [Optional] if deploy fails automatically unlock.
//after('deploy:failed', 'deploy:unlock');

