<?php

namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth; 

use App\User;
use Validator;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;


class UsersController extends BaseController
{
    /**
     * Registro de Usuario (Criando o Token de Usuario)
     *
     * 
     */
    public function register(Request $request) {    
         
        $validator = Validator::make($request->all(), [ 
              'name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users',
              'password' => 'required|min:6',  
              'c_password' => 'required|same:password',
            //   'role' => 'array|required',
            //   'role' => 'integer|exists:roles,id|max:4294967295|required',
            //   'remember_token' => 'max:191|nullable'
    ]);
        // if validation fails
        if ($validator->fails()) {            
           return $this->sendError('Erro de Validacao!!!', $validator->errors(), 400);                        
        }    
 
        $input = $request->all();  
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input); 
        $success['token'] =  $user->createToken('leotradingApp')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'Usuario cadastro com sucesso.');

    }

    /**
     * Login api
     *
     * 
     */
    public function login(Request $request)
    {     
        $validator = Validator::make($request->all(), [ 
            'email' => 'required',
            'password' => 'required',  
  ]);

      if ($validator->fails()) {            
         return $this->sendError('Erro de Validacao!!!', $validator->errors(), 400);                        
      }
          
      if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('leotradingApp')->accessToken;
            $success['name'] =  $user->name; 
            
            return $this->sendResponse($success, 'Usuario logado com sucesso.');

         } else{ 
            return $this->sendError('Sem autorizacao.', ['error'=>'Sem autorizacao'], 401);
       } 

    }

}
