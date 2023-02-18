<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ActoGradoTest extends TestCase
{
    public function testShouldReturnAllActoGrados(){


            $this->get("api/actoGrado", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                'data' => ['*' =>
                    [
                        'titulo',
                        'descripcion',
                        'fecha',
                        'created_at',
                        'updated_at',                        
                    ]
                ],
               
            ]);
            
        }
        
    
        /**
         * /api/actoGrado/id [GET]
         */
        public function testShouldReturnActoGrado(){
            $this->get("api/actoGrado/1", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'fecha',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
    
        /**
         * ActoGrados [POST]
         */
        public function testShouldCreateActoGrado(){
    
            $parameters = [
                'titulo'=>"Acto de grado por secretaria 1",
                'user_id'=>"1",
                'descripcion'=>"Acto de grado por secretaria 1",
                'fecha'=>"2022-02-06"
            ];
    
            $this->post("api/actoGrado", $parameters, []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'fecha',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
        
        /**
         * /api/actoGrado/id [PUT]
         */
        public function testShouldUpdateActoGrado(){
    
            $parameters = [
                'titulo'=>"Acto de grado por secretaria",
                'user_id'=>1,
                'descripcion'=>"Acto de grado por secretaria",
                'fecha'=>"2022-02-06"
            ];
    
            $this->patch("api/actoGrado/42", $parameters, []);
            
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'titulo',
                        'descripcion',
                        'fecha',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
        }

    /**
     * /api/actoGrado/id [DELETE]
     */
    public function testShouldDeleteActoGrado(){
        
        $this->delete("api/actoGrado/41", [], []);
        $this->seeJsonStructure(
            ['data' =>
                []
            ]    
        );
    }

}

