<?php
namespace gregoryv\rutt;

/**
 * CRUDMiddleware maps named resources
 */
class CRUDMiddleware extends AbstractMiddleware
{

  private $mux;
  private $overrideHandler;
  private $factory;

  public function __construct(MuxerInterface $mux,
                              HandlerFactoryInterface &$factory = null) {
    $this->mux = $mux;
    $this->factory = $factory;
    if($factory == null) {
      $this->factory = new DefaultFactory();
    }
  }

  public function route($method, $uri, &$request,
                        ResponseWriterInterface &$response) {
    try {
      $route = $this->mux->match($method, $uri);
    } catch(HttpException $e) {
      $response->writeError($e);
      return;
    }
    $handler = $route->handler;

    // Unless muxer already has an object registered use the factory
    // to create the handler
    if(is_string($handler)) {
      try {
        $handler = $this->factory->create($route);
      } catch(\RuntimeException $e) {
        $response->writeError(new HttpException("Internal Server Error", 500, $e));
        $response->write($e);
        return;
      }
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
    default:
      $response->writeError(new HttpException("Not Implemented", 501));
      return;
    }
    $this->next($method, $uri, $request, $response);
  }

}
