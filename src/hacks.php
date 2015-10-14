<?php

/*
use Psr\Http\Message\ResponseInterface;
use Spark\Adr\PayloadInterface;
use Spark\Formatter\AbstractFormatter;
use Spark\Resolver\ResolverInterface;

class HackedRouter extends Spark\Router {
  private $responder = 'Spark\Responder\HackedChainedResponder';
}

class HackedChainedResponder extends Spark\Responder\ChainedResponder
{
  // private $responders = [
  //   'Spark\Responder\HackedFormattedResponder',
  // ];

  public function construct(ResolverInterface $resolver) {
    echo "iiiii";
    $this->responders = ['Spark\Responder\HackedFormattedResponder'];
    parent::construct($resolver);
  }
}

class HackedFormattedResponder extends Spark\Responder\FormattedResponder
{
  protected function format(
    ResponseInterface $response,
    AbstractFormatter $formatter,
    // HackedAbstractFormatter $formatter,
    PayloadInterface  $payload
  ) {
    // $response = $response->withStatus($formatter->status($payload));
    echo "eeee";
    // $response = $response->withStatus($payload->getStatus());
    $response = $response->withStatus(401);
    $response = $response->withHeader('Content-Type', $formatter->type());

    // Overwrite the body instead of making a copy and dealing with the stream.
    $response->getBody()->write($formatter->body($payload));

    return $response;
  }
}

// abstract class HackedAbstractFormatter extends Spark\Formatter\AbstractFormatter {
//   public function status(PayloadInterface $payload)
//   {
//     // just return whatever numeric HTTP status code was passed in
//     $status = $payload->getStatus();
//     return $status;
//   }
// }
// */
