<?php 
declare(strict_types=1);

namespace Code;
use Code\Exeption\ContainerExeption;

class Container implements \Psr\Container\ContainerInterface
{
    private array  $entries = [];
    public function get(string $id)
    {
        if ($this->has($id)){
            $entry = $this->entries[$id];

            if (is_callable($id)){
                return $entry[$this];
            }
            $id = $entry;
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }   

    public function set(string $id, callable|string $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve(string $id)
    {
        $reflectionClass = new \ReflectionClass($id);

        if(! $reflectionClass->isInstantiable()){
            throw new ContainerExeption();
        }

        $constructor = $reflectionClass->getConstructor();

        if(! $constructor){
            return new $id;
        }

        $parameters = $constructor->getParameters();

        if(! $parameters){
            return new $id;
        }

        $dependencies = array_map(function(\ReflectionParameter $param) use ($id) {
            $name = $param->getName();
            $type = $param->getType();

            if(!$type){
                throw new ContainerExeption('Failed to resolve class' . $id . ' param ' . $name . ' has not type hint.' );
            }

            if($type instanceof \ReflectionUnionType){
                throw new ContainerExeption('Failed to resolve class '. $id . ' param '. $name . ' is a union type param.');
            }

            if($type instanceof \ReflectionNamedType && !$type->isBuiltin()){
                return $this->get($type->getName());
            }

            throw new ContainerExeption('Failed to resolve class '. $id . ' param '. $param . ' is a invalid param.');
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}