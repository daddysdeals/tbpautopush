default_run_options[:pty] = true
set :application, "tbpautoimport"
set :repository, "git@github.com:daddysdeals/tbpautopush.git"
set :scm, :git
set :use_sudo, false
set :deploy_to, "/var/www/daddysdeals.co.za"
set :deploy_via, :remote_cache

after "deploy:update", "tbpautoimport:config"

task :staging do
        role :current, "41.72.150.244"
	set :branch, "staging"
	set :user, "dadstage"
        set :deploy_to, "/var/www/staging.daddysdeals.co.za/admin/tbpautoimport"
	set :dbname, "ddeals_staging"
end

task :testing do
        role :current, "41.72.150.244"
	set :branch, "testing"
	set :user, "dadtest"
        set :deploy_to, "/var/www/testing.daddysdeals.co.za/admin/tbpautoimport"
	set :dbname, "ddeals_testing"
end

task :live do
        role :current, "41.72.150.244"
	set :branch, "master"
	set :user, "dadusr"
        set :deploy_to, "/var/www/daddysdeals.co.za/admin/tbpautoimport"
	set :dbname, "ddeals_db1"
end

namespace :tbpautoimport do
        desc "Create the various symlinks to content not being deployed"
        task :config, :roles => :current do
        	# tasks to copy the config file from shared to the correct place go here
		    run ""
        end
end