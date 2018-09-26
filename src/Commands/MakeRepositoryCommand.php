<?php

namespace Grahh\Artisanplus\Commands;


use Grahh\Artisanplus\ApplicationConfigurator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    public $conf;
    public $modelPath;
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
    protected $signature = 'make:repository {model : Provide and existing model name} {?--folder= : Provide path from config path}';

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
        $this->conf = app()->make(ApplicationConfigurator::class);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $model = Str::ucfirst($this->argument('model'));
            $repositoryFolder = $this->option('folder');

            $base_repo_namespace = config('artisanplus.namespaces.repositories');
            $base_repo_path = app_path($this->conf->namespaceToPath($base_repo_namespace));

            if($repositoryFolder) {
                $repositoryPath = $base_repo_path."/". $repositoryFolder;
                $repositoryNamespace = $base_repo_namespace."\\".$this->conf->pathToNamespace($repositoryFolder);
            } else {
                $repositoryPath = $base_repo_path;
                $repositoryNamespace = $base_repo_namespace;
            }

            $this->path = $repositoryPath;
            $this->namespace = $repositoryNamespace;

            $this->repoName = $model . "Repository";
            $this->modelName = $model;
            $this->namespacedModel = config('artisanplus.namespaces.models') . "\\" . $model;
            $this->modelPath = app_path($this->conf->namespaceToPath($this->namespacedModel).".php");
            if(File::exists($this->modelPath)) {
                $this->generateRepository();
            } else {
                throw new \Exception(sprintf("model %s does not exists \r\n",$this->modelName));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    protected function generateRepository()
    {
        $content = <<<REPO
<?php

namespace $this->namespace;

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

        try {
            if(!File::isDirectory($this->path)) {
                File::makeDirectory($this->path,0755,true);
            }

            if(!File::exists($this->path."/".$this->repoName.".php")) {
                File::put($this->path."/".$this->repoName.".php",$content);
            } else {
                throw new \Exception(sprintf("file %s exists \r\n",$this->repoName.".php"));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }

    }
}