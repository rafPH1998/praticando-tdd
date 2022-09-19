<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private function checkColumn($request, string $columns): bool
    {
        if (!$request->has('columns')) {
            return true;
        }
        return str($request->get('columns'))->contains($columns);
    }

    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'name' => $this->when(
                $this->checkColumn($request, 'name'),
                $this->name
            ),
            'email' => $this->when(
                $this->checkColumn($request, 'email'),
                $this->email
            ),
            $this->mergeWhen($request->get('show') === 'all', [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]),
        ];
    }
}
