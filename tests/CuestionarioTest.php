<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CuestionarioTest extends TestCase
{
    public function testShouldReturnAllCuestionarios(){


            $this->get("api/cuestionario", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                'data' => ['*' =>
                    [
                        'nombre',
                        'descripcion',
                        'tipo',
                        'privacidad',
                        "fecha_inicio",
                        "fecha_fin",
                        'created_at',
                        'updated_at',
                        
                    ]
                ],
               
            ]);
            
        }
        
    
        /**
         * /api/cuestionario/id [GET]
         */
        public function testShouldReturnCuestionario(){
            $this->get("api/cuestionario/2", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'nombre',       
                        'descripcion',      
                        'tipo',     
                        'privacidad', 
                        "fecha_inicio",
                        "fecha_fin",                 
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
    
        /**
         * /cuestionarios [POST]
         */
        public function testShouldCreateCuestionario(){
    
            $parameters = [
                'nombre'=>"Informacion laboral",       
                'descripcion'=>"Informacion laboral",      
                'tipo'=>"cuestionario",     
                'privacidad'=>"publico",
                "user_id"=>"1",
                "objetivo"=>"1,2",
                "fecha_inicio"=>"2023-02-18",
                "fecha_fin"=>"2023-02-18"
            ];
    
            $this->post("api/cuestionario", $parameters, []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'nombre',
                        'descripcion',
                        'tipo',
                        'privacidad',   
                        "fecha_inicio",
                        "fecha_fin",         
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
        /**
         * /api/cuestionario/id [PUT]
         */
        public function testShouldUpdateCuestionario(){
    
            $parameters = [
                'nombre'=>"Informacion laboral ",       
                'descripcion'=>"Informacion laboral 3",      
                'tipo'=>"cuestionario",     
                'privacidad'=>"publico",
                "user_id"=>"1",
                "objetivo"=>"1,2",
                "fecha_inicio"=>"2023-02-18",
                "fecha_fin"=>"2023-02-18"
            ];
    
            $this->patch("api/cuestionario/7", $parameters, []);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'nombre',
                        'descripcion',
                        'tipo',
                        'privacidad',   
                        "fecha_inicio",
                        "fecha_fin",         
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
        }

    /**
     * /api/cuestionario/id [DELETE]
     */
    
    public function testShouldDeleteCuestionario(){
        
        $this->delete("api/cuestionario/8", [], []);
        $this->seeJsonStructure(
            ['data' =>
                []
            ]    
        );
    }

}

