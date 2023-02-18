<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BolsaTrabajoTest extends TestCase
{
    public function testShouldReturnAllBolsaTrabajos(){


            $this->get("api/bolsaTrabajo", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                'data' => ['*' =>
                    [
                        'nombre',
                        'user_id',
                        'empresa',
                        'vacantes',
                        'requisitos',
                        'carreras',
                        'fecha_publicacion',
                        'fecha_disponibilidad',
                        'contacto',
                        'created_at',
                        'updated_at',
                        
                    ]
                ],
               
            ]);
            
        }
        
    
        /**
         * /api/bolsaTrabajo/id [GET]
         */
        public function testShouldReturnBolsaTrabajo(){
            $this->get("api/bolsaTrabajo/9", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'nombre',
                        'user_id',
                        'empresa',
                        'vacantes',
                        'requisitos',
                        'carreras',
                        'fecha_publicacion',
                        'fecha_disponibilidad',
                        'contacto',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
    
        /**
         * /bolsaTrabajos [POST]
         */
        public function testShouldCreateBolsaTrabajo(){
    
            $parameters = [
                'nombre'=>"contador",
                'user_id'=>1,
                'empresa'=>"SIDOR",
                'vacantes'=>3,
                'requisitos'=>"Mayor de edad",
                'carreras'=>"Informatica",
                'fecha_publicacion'=>"2023-02-15",
                'fecha_disponibilidad'=>"2023-02-15",
                'contacto'=>"041255555555",
            ];
    
            $this->post("api/bolsaTrabajo", $parameters, []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'nombre',
                        'user_id',
                        'empresa',
                        'vacantes',
                        'requisitos',
                        'carreras',
                        'fecha_publicacion',
                        'fecha_disponibilidad',
                        'contacto',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }
        
        /**
         * /api/bolsaTrabajo/id [PUT]
         */
        public function testShouldUpdateBolsaTrabajo(){
    
            $parameters = [
                'nombre'=>"contador 2",
                'user_id'=>1,
                'empresa'=>"SIDOR 1",
                'vacantes'=>3,
                'requisitos'=>"Mayor de edad 1",
                'carreras'=>"Informatica 2",
                'fecha_publicacion'=>"2023-02-15",
                'fecha_disponibilidad'=>"2023-02-15",
                'contacto'=>"041255555555",
            ];
    
            $this->patch("api/bolsaTrabajo/5", $parameters, []);
            
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'nombre',
                        'user_id',
                        'empresa',
                        'vacantes',
                        'requisitos',
                        'carreras',
                        'fecha_publicacion',
                        'fecha_disponibilidad',
                        'contacto',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
        }

    /**
     * /api/bolsaTrabajo/id [DELETE]
     */
    public function testShouldDeleteBolsaTrabajo(){
        
        $this->delete("api/bolsaTrabajo/10", [], []);
        $this->seeJsonStructure(
            ['data' =>
                []
            ]    
        );
    }

}

