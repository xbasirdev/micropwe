<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class EventoTest extends TestCase
{
    public function testShouldReturnAllEventos(){


            $this->get("api/evento", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                'data' => ['*' =>
                    [
                        'titulo', 
                        'descripcion', 
                        'fecha', 
                        'lugar', 
                        'carreras', 
                        'imagen',
                        'created_at',
                        'updated_at',
                    ]
                ],
               
            ]);
            
        }
        
    
        /**
         * /api/evento/id [GET]
         */
        public function testShouldReturnEvento(){
            $this->get("api/evento/2", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo', 
                        'descripcion', 
                        'fecha', 
                        'lugar', 
                        'carreras', 
                        'imagen',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
    
        /**
         * /eventos [POST]
         */
        public function testShouldCreateEvento(){
    
            $parameters = [
                'user_id'=>1,
                'titulo' => "Presentacion de musica", 
                'descripcion' => "Presentacion de musica", 
                'fecha' => "2023-02-14", 
                'lugar' => "Atlantico", 
                'imagen' => null,
                'carreras' => "Ingenieria Informatica",
            ];
    
            $this->post("api/evento", $parameters, []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'user_id',
                        'titulo', 
                        'descripcion', 
                        'fecha', 
                        'lugar', 
                        'carreras', 
                        'imagen',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
        
        /**
         * /api/evento/id [PUT]
         */
        public function testShouldUpdateEvento(){
    
            $parameters = [
                'user_id'=>"1",
                'titulo' => "Presentacion de musica 2", 
                'descripcion' => "Presentacion de musica 2", 
                'fecha' => "2023-02-15", 
                'lugar' => "Atlantico", 
                'imagen' => null,
                'carreras' => "Ingenieria Informatica 2",
            ];
    
            $this->patch("api/evento/2", $parameters, []);
            
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'user_id',
                        'titulo', 
                        'descripcion', 
                        'fecha', 
                        'lugar', 
                        'carreras', 
                        'imagen',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
        }

    /**
     * /api/evento/id [DELETE]
     */
    public function testShouldDeleteEvento(){
        
        $this->delete("api/evento/8", [], []);
        $this->seeJsonStructure(
            ['data' =>
                []
            ]    
        );
    }

}

