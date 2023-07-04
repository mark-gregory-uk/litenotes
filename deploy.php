<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('keep_releases', 2);       // Number of releases to keep on hosts
set('default_timeout', 2400);  // The command timeout

set('repository', 'git@github.com:mark-gregory-uk/notes.git');

// Note this seems not to like public as shared directory

add('shared_files', ['.env']);
add('shared_dirs', ['node_modules', 'vendor', 'storage']);
add('writable_dirs', ['node_modules', 'vendor', 'storage']);

// Hosts

host('192.168.0.2')
    ->setRemoteUser('deploy')
    ->set('writable_use_sudo', true)
    ->set('http_user', 'www-data')
    ->set('use_relative_symlink', false)
    ->set('branch', 'main')
    ->set('deploy_path', '/var/www/litenotes')
    ->set('ssh_multiplexing', true)
    ->set('git_tty', false)                         // [Optional] Allocate tty for git clone. Default value is false.
    ->set('ssh_type', 'native');                    // How we communicate with the host system

// Hooks

after('deploy:failed', 'deploy:unlock');
