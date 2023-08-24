<?php

namespace Nng\Nnhelpers\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * ModifyResponse MiddleWare.
 * 
 * 
 * Request handling in MiddleWare / TYPO3 docs:
 * https://bit.ly/3GBcveH
 * 
 */
class ModifyResponse implements MiddlewareInterface 
{
	/**
	 *	@param ServerRequestInterface $request
	 *	@param RequestHandlerInterface $handler
	 *	@return ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface 
	{
		$response = $handler->handle($request);
	
		$cookie = 'xx_typo_user' .date('His'). '=' .$_COOKIE['fe_typo_user']. '; Expires=Wed, 21 Oct 2025 07:28:00 GMT; Path=/;';
		$response = $response->withAddedHeader('Set-Cookie', $cookie);

		die('DAMN!');
		
		return $response;
	}
}