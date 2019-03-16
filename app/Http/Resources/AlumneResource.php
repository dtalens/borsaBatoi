<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlumneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'domicilio' => $this->domicilio,
            'info' => $this->info,
            'bolsa' => $this->bolsa,
            'cv_enlace' => $this->cv_enlace,
            'telefono' => $this->telefono,
            'email' => $this->User->email,
            'ciclos' => $this->myCiclos
        ];
    }


}
