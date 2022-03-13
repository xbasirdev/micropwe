<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'product'], function () use ($router) {
        $router->get('/', ['uses' => 'ProductController@index']);
        $router->post('/', ['uses' => 'ProductController@store']);
        $router->get('/{product}', ['uses' => 'ProductController@show']);
        $router->patch('/{product}', ['uses' => 'ProductController@update']);
        $router->delete('/{product}', ['uses' => 'ProductController@destroy']);
    });
    $router->group(['prefix' => 'actoGrado'], function () use ($router) {
        $router->get('/', ['uses' => 'ActoGradoController@index']);
        $router->post('/', ['uses' => 'ActoGradoController@store']);
        $router->get('/{actoGrado}', ['uses' => 'ActoGradoController@show']);
        $router->patch('/{actoGrado}', ['uses' => 'ActoGradoController@update']);
        $router->delete('/{actoGrado}', ['uses' => 'ActoGradoController@destroy']);
    });
    $router->group(['prefix' => 'presentacionDep'], function () use ($router) {
        $router->get('/', ['uses' => 'PresentacionDepController@index']);
        $router->post('/', ['uses' => 'PresentacionDepController@store']);
        $router->get('/{presentacionDep}', ['uses' => 'PresentacionDepController@show']);
        $router->patch('/{presentacionDep}', ['uses' => 'PresentacionDepController@update']);
        $router->delete('/{presentacionDep}', ['uses' => 'PresentacionDepController@destroy']);
    });

    $router->group(['prefix' => 'evento'], function () use ($router) {
        $router->get('/', ['uses' => 'EventoController@index']);
        $router->post('/', ['uses' => 'EventoController@store']);
        $router->get('/{evento}', ['uses' => 'EventoController@show']);
        $router->patch('/{evento}', ['uses' => 'EventoController@update']);
        $router->delete('/{evento}', ['uses' => 'EventoController@destroy']);
    });

    $router->group(['prefix' => 'actividadExtension'], function () use ($router) {
        $router->get('/', ['uses' => 'ActividadExtensionController@index']);
        $router->post('/', ['uses' => 'ActividadExtensionController@store']);
        $router->get('/{actividadExtension}', ['uses' => 'ActividadExtensionController@show']);
        $router->patch('/{actividadExtension}', ['uses' => 'ActividadExtensionController@update']);
        $router->delete('/{actividadExtension}', ['uses' => 'ActividadExtensionController@destroy']);
    });

    $router->group(['prefix' => 'carrera'], function () use ($router) {
        $router->get('/', ['uses' => 'CarreraController@index']);
        $router->post('/', ['uses' => 'CarreraController@store']);
        $router->get('/{carrera}', ['uses' => 'CarreraController@show']);
        $router->patch('/{carrera}', ['uses' => 'CarreraController@update']);
        $router->delete('/{carrera}', ['uses' => 'CarreraController@destroy']);
    });

    $router->group(['prefix' => 'bolsaTrabajo'], function () use ($router) {
        $router->get('/', ['uses' => 'BolsaTrabajoController@index']);
        $router->post('/', ['uses' => 'BolsaTrabajoController@store']);
        $router->get('/{bolsaTrabajo}', ['uses' => 'BolsaTrabajoController@show']);
        $router->patch('/{bolsaTrabajo}', ['uses' => 'BolsaTrabajoController@update']);
        $router->delete('/{bolsaTrabajo}', ['uses' => 'BolsaTrabajoController@destroy']);
    });

    $router->group(['prefix' => 'egresado'], function () use ($router) {
        $router->get('/', ['uses' => 'EgresadoController@index']);
        $router->post('/', ['uses' => 'EgresadoController@store']);
        $router->get('/{egresado}', ['uses' => 'EgresadoController@show']);
        $router->patch('/{egresado}', ['uses' => 'EgresadoController@update']);
        $router->delete('/{egresado}', ['uses' => 'EgresadoController@destroy']);
    });

    $router->group(['prefix' => 'bolsaEgresado'], function () use ($router) {
        $router->get('/', ['uses' => 'BolsaEgresadoController@index']);
        $router->post('/', ['uses' => 'BolsaEgresadoController@store']);
        $router->get('/{bolsaEgresado}', ['uses' => 'BolsaEgresadoController@show']);
        $router->patch('/{bolsaEgresado}', ['uses' => 'BolsaEgresadoController@update']);
        $router->delete('/{bolsaEgresado}', ['uses' => 'BolsaEgresadoController@destroy']);
    });

    $router->group(['prefix' => 'banco'], function () use ($router) {
        $router->get('/', ['uses' => 'BancoController@index']);
        $router->post('/', ['uses' => 'BancoController@store']);
        $router->get('/{banco}', ['uses' => 'BancoController@show']);
        $router->patch('/{banco}', ['uses' => 'BancoController@update']);
        $router->delete('/{banco}', ['uses' => 'BancoController@destroy']);
    });

    $router->group(['prefix' => 'bancoPregunta'], function () use ($router) {
        $router->get('/', ['uses' => 'BancoPreguntaController@index']);
        $router->post('/', ['uses' => 'BancoPreguntaController@store']);
        $router->get('/{bancoPregunta}', ['uses' => 'BancoPreguntaController@show']);
        $router->patch('/{bancoPregunta}', ['uses' => 'BancoPreguntaController@update']);
        $router->delete('/{bancoPregunta}', ['uses' => 'BancoPreguntaController@destroy']);
    });

    $router->group(['prefix' => 'cuestionario'], function () use ($router) {
        $router->get('/', ['uses' => 'CuestionarioController@index']);
        $router->post('/', ['uses' => 'CuestionarioController@store']);
        $router->get('/{cuestionario}', ['uses' => 'CuestionarioController@show']);
        $router->patch('/{cuestionario}', ['uses' => 'CuestionarioController@update']);
        $router->delete('/{cuestionario}', ['uses' => 'CuestionarioController@destroy']);
    });

    $router->group(['prefix' => 'cuestionarioPregunta'], function () use ($router) {
        $router->get('/', ['uses' => 'CuestionarioPreguntaController@index']);
        $router->post('/', ['uses' => 'CuestionarioPreguntaController@store']);
        $router->get('/{cuestionarioPregunta}', ['uses' => 'CuestionarioPreguntaController@show']);
        $router->patch('/{cuestionarioPregunta}', ['uses' => 'CuestionarioPreguntaController@update']);
        $router->delete('/{cuestionarioPregunta}', ['uses' => 'CuestionarioPreguntaController@destroy']);
    });

    $router->group(['prefix' => 'cuestionarioRespuesta'], function () use ($router) {
        $router->get('/', ['uses' => 'CuestionarioRespuestaController@index']);
        $router->post('/', ['uses' => 'CuestionarioRespuestaController@store']);
        $router->get('/{cuestionarioRespuesta}', ['uses' => 'CuestionarioRespuestaController@show']);
        $router->patch('/{cuestionarioRespuesta}', ['uses' => 'CuestionarioRespuestaController@update']);
        $router->delete('/{cuestionarioRespuesta}', ['uses' => 'CuestionarioRespuestaController@destroy']);
    });

    $router->group(['prefix' => 'objetivoCuestionario'], function () use ($router) {
        $router->get('/', ['uses' => 'ObjetivoCuestionarioController@index']);
        $router->post('/', ['uses' => 'ObjetivoCuestionarioController@store']);
        $router->get('/{objetivoCuestionario}', ['uses' => 'ObjetivoCuestionarioController@show']);
        $router->patch('/{objetivoCuestionario}', ['uses' => 'ObjetivoCuestionarioController@update']);
        $router->delete('/{objetivoCuestionario}', ['uses' => 'ObjetivoCuestionarioController@destroy']);
    });

    $router->group(['prefix' => 'opcionPregunta'], function () use ($router) {
        $router->get('/', ['uses' => 'OpcionPreguntaController@index']);
        $router->post('/', ['uses' => 'OpcionPreguntaController@store']);
        $router->get('/{opcionPregunta}', ['uses' => 'OpcionPreguntaController@show']);
        $router->patch('/{opcionPregunta}', ['uses' => 'OpcionPreguntaController@update']);
        $router->delete('/{opcionPregunta}', ['uses' => 'OpcionPreguntaController@destroy']);
    });

    $router->group(['prefix' => 'tipoPregunta'], function () use ($router) {
        $router->get('/', ['uses' => 'TipoPreguntaController@index']);
        $router->post('/', ['uses' => 'TipoPreguntaController@store']);
        $router->get('/{tipoPregunta}', ['uses' => 'TipoPreguntaController@show']);
        $router->patch('/{tipoPregunta}', ['uses' => 'TipoPreguntaController@update']);
        $router->delete('/{tipoPregunta}', ['uses' => 'TipoPreguntaController@destroy']);
    });

    $router->group(['prefix' => 'verification'], function () use ($router) {
        $router->get('/', ['uses' => 'VerificationController@index']);
        $router->post('/', ['uses' => 'VerificationController@store']);
        $router->get('/{verification}', ['uses' => 'VerificationController@show']);
        $router->patch('/{verification}', ['uses' => 'VerificationController@update']);
        $router->delete('/{verification}', ['uses' => 'VerificationController@destroy']);
    });


});