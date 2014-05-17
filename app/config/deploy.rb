set :application, "Job Manager"
set :domain,      "job.fresh.local"
set :user,	  "root"
set :use_sudo,	  false
set :deploy_to,   "/var/www/jobmanager"
set :app_path,    "app"

set :writable_dirs,	["app/cache", "app_logs"]
set :webserver_user,	"www-data"
set :permission_method,	:acl
set :use_set_perimssions,	true


set :repository,  "file:///opt/git/jobmanager.git"
set :deploy_via,	:copy
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set :shared_files,    ["app/config/parameters.yml"]
set :shared_chlidren, [app_path + "/cache", app_path + "/logs", web_path + "/uploads"]
set :use_composer,   true
set :update_vendors, true
set :keep_releases,  3

task :upload_parameters do
  origin_file = "app/config/parameters_inte.yml"
  destination_file = shared_path + "/app/config/parameters.yml" # Notice the shared_path

  try_sudo "mkdir -p #{File.dirname(destination_file)}"
  top.upload(origin_file, destination_file)
end

after "deploy:setup", "upload_parameters"

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

