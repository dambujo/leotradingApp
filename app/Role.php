<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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


    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
