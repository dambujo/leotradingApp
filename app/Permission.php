<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'description'];

    public static function storeValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'description' => 'max:191|required',
            'permission' => 'array|required'
        ];
    }
 
    public static function updateValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'description' => 'max:191|required',
            'permission' => 'array|required'
        ];
    }


     
}
