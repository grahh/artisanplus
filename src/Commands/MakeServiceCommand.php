<?php

namespace Grahh\Artisanplus\Commands;


use Grahh\Artisanplus\ApplicationConfigurator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    public $path;
    public $namespace;
    public $serviceName;
    public $conf;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : Service name that will be postfixed as *Service.php} {?--namespace= : If you need to change namespace and create file somewhere far from config directory use namespace}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $conf = app()->make(ApplicationConfigurator::class);
        $path = $conf->namespaceToPath( config('artisanplus.namespaces.services') );

        if($path) {
            $conf->setServicesPath($path);
        } else {
            $conf->setServicesPath();
        }

        $this->path = $conf->getServicesPath();
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

        $this->serviceName = Str::studly($this->argument('name'))."Service";
        $this->generateService();
    }

    protected function generateService()
    {
        if($this->namespace) {
            $additional_path = $this->conf->namespaceToPath($this->namespace);
            $serviceNamespace = config('artisanplus.namespaces.services')."\\".$this->namespace;
        } else {
            $serviceNamespace = config('artisanplus.namespaces.services');
        }

        $content = <<<SERVICE
<?php

namespace $serviceNamespace;

use \Grahh\Artisanplus\Base\BaseService;
use \Grahh\Artisanplus\Contracts\ShouldReturnView;
use Illuminate\View\View;
use Illuminate\Support\Collection;

class $this->serviceName extends BaseService implements ShouldReturnView
{
    public function __constructor()
    {
        parent::__construct();
        \$this->setActive(true);
        \$this->messages->put('errors',__('errors'));
    }
    
    public function returnViewIfExists(string \$path, \$dto = []): View
    {
        if(is_iterable(\$dto) && view()->exists(\$path)) {
            return view(\$path,\$dto);
        } else {
            abort(500, \$this->getMessage('errors.view_not_found'));
        }
    }
    
    public function index()
    {
        //
    }
}
SERVICE;

        if(isset($additional_path)) {
            if(!File::isDirectory(app_path($this->path)."/".$additional_path)) {
                File::makeDirectory(app_path($this->path."/".$additional_path),0755,true);
            }

            if(!File::exists(app_path($this->path."/".$additional_path."/".$this->serviceName.".php"))) {
                File::put(app_path($this->path."/".$additional_path."/".$this->serviceName.".php"),$content);
            } else {
                dd('file exists');
            }
        } else {
            if(!File::isDirectory(app_path($this->path))) {
                File::makeDirectory(app_path($this->path),0755,true);
            }

            if(!File::exists(app_path($this->path . "/" . $this->serviceName . ".php"))) {
                File::put(app_path($this->path . "/" . $this->serviceName . ".php"), $content);
            } else {
                dd('file exists');
            }
        }

        dd('error. Not finished');
    }
}