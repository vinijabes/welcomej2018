<?php defined('BASEPATH') OR exit('No direct script access allowed');


function mensagens(){
    if(isset($_SESSION['danger']) && $_SESSION['danger'] != ''){
        $html = '<div class="alert alert-danger">'.
                $_SESSION['danger'].'</div>';
    }if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
        $html = '<div class="alert alert-success >'.
                $_SESSION['success'].'</div>'; 
    }

    return isset($html) ? $html : '';
}



function breadcrumbs($controlador, $funcao){

	$controlador_verbosename = '';
	$funcao_verbosename = '';
	$html = '';
	$html.= '<nav aria-label="breadcrumb">
  <ol class="breadcrumb">';

  if($controlador == 'Admin') $controlador_verbosename = 'Início';
  else if($controlador == 'Noticia') $controlador_verbosename = 'Publicações';
  else if($controlador == 'Video') $controlador_verbosename = 'Vídeos';
  else if($controlador == 'Institucional') $controlador_verbosename = 'Institucionais';
  else if($controlador == 'Usuario') $controlador_verbosename = 'Usuários';
  else if($controlador == 'PedidoOracao') $controlador_verbosename = 'Pedidos de Oração';
  else if($controlador == 'Configuracao') $controlador_verbosename = 'Configurações';
  else if($controlador == 'Contact') $controlador_verbosename = 'Contatos';
  else if($controlador == 'Galeria') $controlador_verbosename = 'Galerias';


  if($funcao == 'visualizar') $funcao_verbosename = 'Listar';
  if($funcao == 'editar') $funcao_verbosename = 'Listar';
  if($funcao == 'listar') $funcao_verbosename = 'Listar';
  if($funcao == 'cadastrar') $funcao_verbosename = 'Cadastrar';


  if($controlador == 'Admin'){
    $html.= '<li class="breadcrumb-item"><a style="color:black;" href="'.base_url('Admin').'">'.$controlador_verbosename.'</a></li>';
  }else{
    $html.= '<li class="breadcrumb-item"><a style="color:black;" href="'.base_url('Admin').'">Início</a></li>';
    $html.= '<li class="breadcrumb-item"><a style="color:black;" href="'.base_url($controlador).'">'.$controlador_verbosename.'</a></li>';
    $html.= '<li class="breadcrumb-item active"  aria-current="page">'.$funcao_verbosename.'</li>';

  }
  $html.='</ol></nav>';

  return $html;
}

function hasUserLevel($level){
    $user = unserialize($_SESSION['usuario']);
    if($level < $user->getTipoUsuario()){
        return false;
    }
    return true;
}

?>