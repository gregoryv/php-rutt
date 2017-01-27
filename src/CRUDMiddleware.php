<?php
namespace gregoryv\rutt;

/**
 * CRUDMiddleware maps named resources
 */
class CRUDMiddleware extends AbstractMiddleware
{

  private $mux;
  private $factory;

  public function __construct(HandlerFactoryInterface &$factory) {
    $mux = new Mux();
    $mux->add('GET|POST|PATCH|DELETE|PUT', '\/(\w+)\/?(\d+)?', 'resource');
    $this->mux = $mux;
    $this->factory = $factory;
  }

  public function route($method, $uri, &$request,
                        ResponseWriterInterface &$response) {
    try {
      $route = $this->mux->match($method, $uri);
    } catch(HttpException $e) {
      $response->writeError($e);
      return;
    }
    $resource = $route->parts[1];
    $id = $route->parts[2];
    // Unless muxer already has an object registered use the factory
    // to create the handler

    try {
      $handler = $this->factory->create($resource, $id);
    } catch(HttpException $e) {
      $response->writeError($e);
      return;
    } catch(\Exception $e) {
      $response->writeError(new HttpException("Internal Server Error", 500, $e));
      return;
    }


    // Map http method to handler method
    switch ($method) {
    case 'PUT':
        // This is JSON specific
        $request = json_decode(file_get_contents("php://input"), true);
        $handler->create($request, $response);
      break;
    case 'GET':
      $handler->read($request, $response);
      break;
    case 'PATCH':
    case 'POST':
      $handler->update($request, $response);
      break;
    case 'DELETE':
      $handler->delete($request, $response);
      break;
    }
    $this->next($method, $uri, $request, $response);
  }

}
