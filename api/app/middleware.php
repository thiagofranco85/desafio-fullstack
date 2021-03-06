<?php 

use App\Entity\Usuario;
use App\Service\UsuarioService;
use App\Helper\FuncoesHelper; 

class AutenticacaoTokenMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    
	
    public function __invoke($request, $response, $next)
    { 
        try{
			$tokenHeader = $request->getHeader('token');
	    	$emailHeader = $request->getHeader('email');
	    	    	
	    	$usuario = new Usuario();
	    	$usuario->email = $emailHeader;
	    	$usuario->token = $tokenHeader; 
	    	 	
	    	
	    	$uS = new UsuarioService( $usuario );
	    	$verificado = $uS->verificarToken();
	    	
	    	$status = $response->getStatusCode();
				
		}catch( \Exception $e ){ 
			$msg = $e->getMessage();
			die( FuncoesHelper::formatarSaidaJson(401,"Requisição não autorizada! Token Inválido!",[],1));
		}
		
		return $next($request, $response); 
    }
}