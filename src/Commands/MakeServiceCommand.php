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
    protected $signature = 'make:service {name : Service name that will be postfixed as *Service.php}';

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
        $name = $this->argument('name');
        $name = str_replace("\\",'/',$name);
        //now we have One/Two/Three string

        $base_namespace = config('artisanplus.namespaces.services');
        $base_path = app_path($this->conf->namespaceToPath($base_namespace));

        $name = collect(explode('/',$name));

        if($name->count() > 1) {
            $pop = $name->pop();
            $this->namespace = $base_namespace."\\".$this->conf->pathToNamespace($name->implode('/'));
            $this->path = $base_path."/".$name->implode('/');
        } else {
            $this->namespace = $base_namespace;
            $this->path = $base_path."/";
        }
        $this->serviceName = isset($pop) ? $pop."Service" : $name->last()."Service";
        $this->generateService();
    }

    protected function generateService()
    {
        $content = <<<SERVICE
<?php

namespace $this->namespace;

use \Grahh\Artisanplus\Base\BaseService;
use \Grahh\Artisanplus\Contracts\ShouldReturnView;
use Illuminate\View\View;

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
        try {
            if(!File::isDirectory($this->path)) {
                File::makeDirectory($this->path,0755,true);
            }

            if(!File::exists($this->path.'/'.$this->serviceName.".php")) {
                File::put($this->path.'/'.$this->serviceName.".php",$content);
                die();
            } else {
                throw new \Exception(sprintf("file %s exists \r\n",$this->serviceName.".php"));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}