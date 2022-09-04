<?php

if(!function_exists('usuarioAdministrador'))
{
        /**
        * Return users with role administrator
        * @param null $path
        * @return string
        */
        function usuarioAdministrador()
        {
                return App\User::doesntHave("egresado")->get();
        }
}

if(!function_exists('usuarioEgresado'))
{
        /**
        * Return users with role graduate
        * @param null $path
        * @return string
        */
        function usuarioEgresado()
        {
                return App\User::whereHas("egresado")->with("egresado")->get();
        }
}

if(!function_exists('usuariosEgresadosConNotificacionesActivas'))
{
        /**
        * Return users with role graduate
        * @param null $path
        * @return string
        */
        function usuariosEgresadosConNotificacionesActivas()
        {
                return App\User::whereHas("egresado", function ($query) {
                    $query->where('egresado.notificacion',"=", true);
                })->get();
        }
}