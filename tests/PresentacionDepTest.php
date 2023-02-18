<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PresentacionDepTest extends TestCase
{
    public function testShouldReturnAllPresentacionDep(){


            $this->get("api/presentacionDep", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                'data' => ['*' =>
                    [
                        'titulo',
                        'descripcion',
                        'deporte',
                        'lugar',
                        'fecha',
                        'created_at',
                        'updated_at',                        
                    ]
                ],
               
            ]);
            
        }
        
    
        /**
         * /api/presentacionDep/id [GET]
         */
        public function testShouldReturnPresentacionDep(){
            $this->get("api/presentacionDep/1", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'deporte',
                        'lugar',
                        'fecha',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
    
        /**
         * PresentacionDep [POST]
         */
        public function testShouldCreatePresentacionDep(){
    
            $parameters = [
                'titulo'=>"Juego de baloncesto 1",
                'user_id'=>"1",
                'descripcion'=>"Juego de baloncesto 1",
                'deporte'=>"Baloncesto 1",
                'lugar'=>"Villa asia",
                'fecha'=>"2022-02-06"
            ];
    
            $this->post("api/presentacionDep", $parameters, []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'deporte',
                        'lugar',
                        'fecha',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
        
        /**
         * /api/presentacionDep/id [PUT]
         */
        public function testShouldUpdatePresentacionDep(){
    
            $parameters = [
                'titulo'=>"Juego de baloncesto",
                'user_id'=>1,
                'descripcion'=>"Juego de baloncesto",
                'deporte'=>"Baloncesto",
                'lugar'=>"Villa asia",
                'fecha'=>"2022-02-06"
            ];
    
            $this->patch("api/presentacionDep/3", $parameters, []);
            
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'deporte',
                        'lugar',
                        'fecha',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
        }

    /**
     * /api/presentacionDep/id [DELETE]
     */
    public function testShouldDeletePresentacionDep(){
        
        $this->delete("api/presentacionDep/4", [], []);
        $this->seeJsonStructure(
            ['data' =>
                []
            ]    
        );
    }

}

