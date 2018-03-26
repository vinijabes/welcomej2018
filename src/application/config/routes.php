<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route[LOGIN_URL] = 'AuthLog/index';
// $route['Diretoria'] = 'Diretoria_Controller';
$route['Diretoria'] = "Diretoria_controller/index";
$route['Diretoria/visualizar'] = "Diretoria_controller/visualizar";
$route['Diretoria/visualizar/(:any)/(:any)/(:any)/(:any)'] = "Diretoria_controller/visualizar/$1/$2/$3/$4";
$route['Diretoria/visualizar/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Diretoria_controller/visualizar/$1/$2/$3/$4/$5";
$route['Diretoria/insert'] = "Diretoria_controller/insert";
$route['Diretoria/update'] = "Diretoria_controller/update";
$route['Diretoria/delete/(:any)'] = "Diretoria_controller/delete/$1";

$route['Usuario'] = "Usuario_controller/index";
$route['Usuario/visualizar'] = "Usuario_controller/visualizar";
$route['Usuario/visualizar/(:any)/(:any)/(:any)/(:any)'] = "Usuario_controller/visualizar/$1/$2/$3/$4";
$route['Usuario/visualizar/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Usuario_controller/visualizar/$1/$2/$3/$4/$5";
$route['Usuario/insert'] = "Usuario_controller/insert";
$route['Usuario/update'] = "Usuario_controller/update";
$route['Usuario/delete/(:any)'] = "Usuario_controller/delete/$1";

$route['Servico'] = "Servico_controller/index";
$route['Servico/visualizar'] = "Servico_controller/visualizar";
$route['Servico/visualizar/(:any)/(:any)/(:any)/(:any)'] = "Servico_controller/visualizar/$1/$2/$3/$4";
$route['Servico/visualizar/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Servico_controller/visualizar/$1/$2/$3/$4/$5";
$route['Servico/insert'] = "Servico_controller/insert";
$route['Servico/update'] = "Servico_controller/update";
$route['Servico/delete/(:any)'] = "Servico_controller/delete/$1";

$route['Membro'] = "Membro_controller/index";
$route['Membro/visualizar'] = "Membro_controller/visualizar";
$route['Membro/visualizar/(:any)/(:any)/(:any)/(:any)'] = "Membro_controller/visualizar/$1/$2/$3/$4";
$route['Membro/visualizar/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Membro_controller/visualizar/$1/$2/$3/$4/$5";
$route['Membro/insert'] = "Membro_controller/insert";
$route['Membro/update'] = "Membro_controller/update";
$route['Membro/delete/(:any)'] = "Membro_controller/delete/$1";

$route['Noticia'] = "Noticia_controller/index";
$route['Noticia/visualizar'] = "Noticia_controller/visualizar";
$route['Noticia/visualizar/(:any)/(:any)/(:any)/(:any)'] = "Noticia_controller/visualizar/$1/$2/$3/$4";
$route['Noticia/visualizar/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Noticia_controller/visualizar/$1/$2/$3/$4/$5";
$route['Noticia/insert'] = "Noticia_controller/insert";
$route['Noticia/update'] = "Noticia_controller/update";
$route['Noticia/delete/(:any)'] = "Noticia_controller/delete/$1";

$route['Projeto'] = "Projeto_controller/index";
$route['Projeto/visualizar'] = "Projeto_controller/visualizar";
$route['Projeto/visualizar/(:any)/(:any)/(:any)/(:any)'] = "Projeto_controller/visualizar/$1/$2/$3/$4";
$route['Projeto/visualizar/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Projeto_controller/visualizar/$1/$2/$3/$4/$5";
$route['Projeto/insert'] = "Projeto_controller/insert";
$route['Projeto/update'] = "Projeto_controller/update";
$route['Projeto/delete/(:any)'] = "Projeto_controller/delete/$1";

$route['Parceiro'] = "Parceiro_controller/index";
$route['Parceiro/visualizar'] = "Parceiro_controller/visualizar";
$route['Parceiro/visualizar/(:any)/(:any)/(:any)/(:any)'] = "Parceiro_controller/visualizar/$1/$2/$3/$4";
$route['Parceiro/visualizar/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Parceiro_controller/visualizar/$1/$2/$3/$4/$5";
$route['Parceiro/insert'] = "Parceiro_controller/insert";
$route['Parceiro/update'] = "Parceiro_controller/update";
$route['Parceiro/delete/(:any)'] = "Parceiro_controller/delete/$1";

$route['Configuracao'] = "Configuracao_controller/index";
$route['Configuracao/insert'] = "Configuracao_controller/insert";
$route['Configuracao/delete/(:any)'] = "Configuracao_controller/delete/$1";

$route['Sobre'] = "Sobre_controller/index";
$route['Sobre/insert'] = "Sobre_controller/insert";
$route['Sobre/update'] = "Sobre_controller/update";
$route['Sobre/delete/(:any)'] = "Sobre_controller/delete/$1";