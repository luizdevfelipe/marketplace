<?php 
namespace Code;

class App

{
    public function __construct(protected Router $router, protected array $request)
    {
        
    }

    public function run()
    {
        try{
            echo $this->router->resolve($this->request['uri'], $this->request['method']);
        } catch (\Code\Exeption\RouteNotFoundExeption) {            
            http_response_code(404);
            echo View::make('error/404');
        }        
    }
}