<?php 
namespace Code;

class App

{
    protected static DB $connection;
    public function __construct(protected Router $router, protected array $request, DB $conn)
    {        
        static::$connection = $conn;
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

    public static function DB(): DB
    {
        return static::$connection;
    }
}