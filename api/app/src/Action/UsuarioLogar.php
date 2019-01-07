<?php
namespace App\Action;
 
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\ORM\EntityManager;
use \App\Entity\Usuario;
use \App\Service\UsuarioService;
use \App\Helper\FuncoesHelper;

class UsuarioLogar
{ 
    private $em; 

    public function __construct(EntityManager $em)
    { 
        $this->em = $em;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
    	try{
			$usuario = new Usuario();
        	$usuario->setEmail('thiago.boo@gmail.com');
        	$usuario->setSenha('123456');
        
        	$us = new \App\Service\UsuarioService( $usuario, $this->em );
        	$token = $us->logar();  
        	 
        	
        	if( $token ){				
				$erro = 0;
        		$msg = "Usuário Logado com Sucesso!";
        		$dados = ['token'=>$token];
			}
			
		}catch( \Exception $e ){
			$erro = 1;
			$msg = $e->getMessage();
			$dados = [];			
		}               
        
        $status = $response->getStatusCode();
        
        return FuncoesHelper::formatarSaidaJson($status, $msg, $dados, $erro);
    }
}
