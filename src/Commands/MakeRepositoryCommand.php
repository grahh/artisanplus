<?php

namespace Grahh\Artisanplus\Commands;


use Grahh\Artisanplus\ApplicationConfigurator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    public $model_path;
    public $conf;
    public $path;
    public $namespacedModel;
    public $modelName;
    public $repoName;
    public $namespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model : Provide and existing model name} {?--namespace= : If you need to change namespace and create file somewhere far from config directory use namespace}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates repository for given model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $conf = app()->make(ApplicationConfigurator::class);
        $path = $conf->namespaceToPath(config('artisanplus.namespaces.repositories'));

        if($path) {
            $conf->setRepositoriesPath($path);
        } else {
            $conf->setRepositoriesPath();
        }

        $this->path = $conf->getRepositoriesPath();
        $this->conf = $conf;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->option('namespace')) {
            $this->namespace = $this->conf
                ->prepareNamespace($this->option('namespace'));
        }

        $model = $this->argument('model');
        if(preg_match('/[-_]/',$model)) {
            $model = Str::studly($model);
        } else {
            $model = Str::ucfirst($model);
        }
        $this->repoName = $model . "Repository";
        $this->modelName = $model;
        $this->namespacedModel = config('artisanplus.namespaces.models') . "\\" . $model;
        $this->generateRepository();
    }

    protected function generateRepository()
    {
        if($this->namespace) {
            $additional_path = $this->conf->namespaceToPath($this->namespace);
            $repositoryNamespace = config('artisanplus.namespaces.repositories')."\\".$this->namespace;
        } else {
            $repositoryNamespace = config('artisanplus.namespaces.repositories');
        }

        $content = <<<REPO
<?php

namespace $repositoryNamespace;

use $this->namespacedModel;
use Grahh\Artisanplus\Base\BaseRepository;

class $this->repoName extends BaseRepository 
{
    public function __construct($this->modelName \$model)
    {
        parent::__construct(\$model);
    }
}
REPO;

        if(isset($additional_path)) {
            if(!File::isDirectory(app_path($this->path)."/".$additional_path)) {
                File::makeDirectory(app_path($this->path."/".$additional_path),0755,true);
            }

            File::put(app_path($this->path."/".$additional_path."/".$this->repoName.".php"),$content);
        } else {
            if(!File::isDirectory(app_path($this->path))) {
                File::makeDirectory(app_path($this->path),0755,true);
            }

            File::put(app_path($this->path."/".$this->repoName.".php"),$content);
        }
    }
}