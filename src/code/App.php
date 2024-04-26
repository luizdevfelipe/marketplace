<?php
namespace Code;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class App
{    
    protected Config $config;

    public function __construct(
        protected Router $router,
        protected Container $container,
        protected array $request
    ) {
        $this->config = new Config($_ENV);
    }

    public function run()
    {
        try {
            $this->initDb();
            echo $this->router->resolve($this->request['uri'], $this->request['method']);           
        } catch (\Code\Exeption\RouteNotFoundExeption) {
            http_response_code(404);
            echo View::make('error/404');
        }
    }

    public function initDb()
    {
        $capsule = new Capsule;
        $capsule->addConnection($this->config->db);
        $capsule->setEventDispatcher(new Dispatcher($this->container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
