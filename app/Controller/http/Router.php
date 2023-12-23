<?php
namespace App\Controller\Http;

use \Closure;
use \ReflectionFunction;

use \App\Model\Enum\HttpCode;
use \App\Controller\Pages\Error;
use \App\Model\Log\LogManager;
use \App\Controller\Exception\HttpException;

class Router {
    const LOG_FILE_SET = 'routesLog';
    
    private $url = '';
    private $prefix = '';
    private $routes = [];
    private $request;

    public function __construct($url){
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

//gets_and_setters_____________________________________________________________________________________________________________________________________________________________________________

    private function setPrefix() { $this->prefix = parse_url($this->url)['path'] ?? ''; }

    private function getUri() {
        $uri = $this->request->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return end($xUri);
    }

    private function getRoute() {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();
        
        foreach($this->routes as $patternRoute=>$methods){
            if(preg_match($patternRoute, $uri, $matches)){
                if(isset($methods[$httpMethod])){
                    unset($matches[0]);
                    
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    return $methods[$httpMethod];
                }
                throw new HttpException($this->request->getUrl(), 405, 2);
            }
        }
        throw new HttpException($this->request->getUrl(), 404, 2);
    }

    private function addRoute($method, $route, $params = []) {      
        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $params['variables'] = [];

        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)){
            $route = preg_replace($patternVariable,'(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        $patternRoute = '/^'.str_replace('/','\/', $route).'$/';
        $this->routes[$patternRoute][$method] = $params;
    }

    
//Other________________________________________________________________________________________________________________________________________________________________
    public function get($route, $params = [])    { return $this->addRoute('GET', $route, $params); }

    public function post($route, $params = [])   { return $this->addRoute('POST', $route, $params); }

    public function put($route, $params = [])    { return $this->addRoute('PUT', $route, $params); }

    public function delete($route, $params = []) { return $this->addRoute('DELETE', $route, $params); }

    public function run(){
        try{     
            $route = $this->getRoute();
            if(!isset($route['controller'])) throw new HttpException($this->request->getUrl(), 500, 4);
           
            $args = [];
            $reflection = new ReflectionFunction($route['controller']);
     
            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }
            
            return call_user_func_array($route['controller'], $args);
        } catch (HttpException $e) {
            $content = Error::getHttpErrorPage($e->getHttpCode());
            LogManager::log($e->getHttpCode(), $e->getSeverity(), $e->getMessage(), self::LOG_FILE_SET);
            return new Response($e->getHttpCode(), $content);
        }
    }

}