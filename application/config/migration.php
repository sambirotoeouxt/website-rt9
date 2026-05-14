<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Enable/Disable Migrations
| -------------------------------------------------------------------
|
| Migrations are disabled by default for security reasons.
| You should enable migrations whenever you intend to do a fresh install
| or upgrade an existing application. Disable migrations if you want to
| stick with your current database schema.
| Uncomment the 'enabled' line below to turn migrations on or off.
|
*/
//$config['migration_enabled'] = FALSE;

/*
| -------------------------------------------------------------------
| Migration Type
| -------------------------------------------------------------------
|
| Migration file names may be based on a sequential identifier or on
| a timestamp. Options are:
|
|   sequential = Migration files will be named: 001_*.php, 002_*.php, etc.
|   timestamp  = Migration files will be named: 20121031104401_*.php
|
| Note: If this is set to 'sequential', the new migration numbers
| will be written the same way.
*/
$config['migration_type'] = 'timestamp';

/*
| -------------------------------------------------------------------
| Migrations table
| -------------------------------------------------------------------
|
| This is the name of the table that will store the current migrations state.
| When migrations runs it will store in a database table which migration
| level the system is at. It then compares the migration level in this
| table to the $config['migration_version'] if on windows it needs to be
| in a pursable by the file system.
|
*/
$config['migration_table'] = 'migrations';

/*
| -------------------------------------------------------------------
| Auto Migrate To Latest
| -------------------------------------------------------------------
|
| If this is set to TRUE, "Up" migrations will be run automatically
| whenever the application page is requested (with conditions).
|
*/
$config['migration_auto_latest'] = FALSE;

/*
| -------------------------------------------------------------------
| Migration Version
| -------------------------------------------------------------------
|
| This is used to set migration version that the file system should be on.
| If you run $this->migration->latest() this is the version that schema will
| be upgraded / downgraded to.
*/
$config['migration_version'] = 0;

/*
| -------------------------------------------------------------------
| Skip on Errors
| -------------------------------------------------------------------
|
| This setting will skip migration triggering if a db error occurred.
|
*/
$config['migration_skip_on_error'] = FALSE;
