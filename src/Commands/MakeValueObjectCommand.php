<?php

namespace Grahh\Artisanplus\Commands;


use Grahh\Artisanplus\ApplicationConfigurator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeValueObjectCommand extends Command
{
    public $namespace;
    public $conf;
    public $path;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vo {name : Value Object name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Value Object';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->conf = app()->make(ApplicationConfigurator::class);
        $this->namespace = config('artisanplus.namespaces.value_objects') ?? dd('no namespace in configs');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $this->name = Str::studly($name);
        $this->path = app_path($this->conf->namespaceToPath($this->namespace));
        $this->create();
    }

    private function create()
    {
        $content = <<<VO
<?php

namespace $this->namespace;

use \Grahh\Artisanplus\Contracts\ValueObject;

final class $this->name implements ValueObject
{
    private \$a;

    public function __construct(string \$a) 
    {
        \$this->a = \$a;
    }
    
    public function __get(string \$name) {
        return \$this->{\$name} ?? null;
    }

    //close all!
    public function __set(\$k,\$v){}
    public function __isset(\$k){}
    public function __unset(\$k){}
    public function __clone(){}
    public function __toString(): string { return ''; }
    public function __call(\$k,\$v){}
    public static function __callStatic(\$k,\$v){}
    public function __sleep(){}
    public function __wakeup(){}
    public function __invoke(){}
    public function __destruct(){}
    public function __set_state(){}
    public function __debuginfo(){}
}
VO;

        try {
            if(!File::isDirectory($this->path)) {
                File::makeDirectory($this->path,0755,true);
            }

            if(!File::exists($this->path.'/'.$this->name.".php")) {
                File::put($this->path.'/'.$this->name.".php",$content);
                die();
            } else {
                throw new \Exception(sprintf("file %s exists \r\n",$this->name.".php"));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }

    }
}