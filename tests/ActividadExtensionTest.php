<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ActividadExtensionTest extends TestCase
{
    public function testShouldReturnAllActividadExtensions(){


            $this->get("api/actividadExtension", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                'data' => ['*' =>
                    [
                        'titulo',
                        'descripcion',
                        'tipo',
                        'carrera',
                        'periodo',
                        'created_at',
                        'updated_at',                        
                    ]
                ],
               
            ]);
            
        }
        
    
        /**
         * /api/actividadExtension/id [GET]
         */
        public function testShouldReturnActividadExtension(){
            $this->get("api/actividadExtension/1", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'tipo',
                        'carrera',
                        'periodo',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
    
        /**
         * actividadExtensions [POST]
         */
        public function testShouldCreateActividadExtension(){
    
            $parameters = [
                'titulo'=>"Curso pregrado 1",
                'user_id'=>"1",
                'descripcion'=>"Curso pregrado 1",
                'tipo'=>"curso 1",
                'carrera'=>1,
                'periodo'=>"2022-02-06"
            ];
    
            $this->post("api/actividadExtension", $parameters, []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'tipo',
                        'carrera',
                        'periodo',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
        
        /**
         * /api/actividadExtension/id [PUT]
         */
        public function testShouldUpdateActividadExtension(){
    
            $parameters = [
                'titulo'=>"Curso pregrado",
                'user_id'=>1,
                'descripcion'=>"Curso pregrado",
                'tipo'=>"curso",
                'carrera'=>1,
                'periodo'=>"2022-02-06"
            ];
    
            $this->patch("api/actividadExtension/5", $parameters, []);
            
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'tipo',
                        'carrera',
                        'periodo',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
        }

    /**
     * /api/actividadExtension/id [DELETE]
     */
    public function testShouldDeleteActividadExtension(){
        
        $this->delete("api/actividadExtension/7", [], []);
        $this->seeJsonStructure(
            ['data' =>
                []
            ]    
        );
    }

}

