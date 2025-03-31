<?php

namespace App\Http\Services;
use Illuminate\Http\Request;
use App\Models\User;

class UserService
{
    public function __construct(private User $user)
    {
    }
    public function index()
    {
        $users = $this->user->paginate(10);
        if(!$users){
            return response()->json(['message' => 'Nenhum usuário encontrado'], 404);
        }
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        $data = $request->validated();
        $user = $this->user->create($data);
        if(!$user){
            return response()->json(['message' => 'Erro ao criar usuário'], 400);
        }
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->user->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, string $id)
    {
        $data = $request->validated();
        $user = $this->user->find($id);
        if(!$user){
            return response()->json( ['message' => 'Usuário não encontrado'], 404);
        }
        if(isset($data['password'])){
            $user->password = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        $user->update($data);
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->user->find($id);
        if(!$user){
            return response()->json( ['message' => 'Usuário não encontrado'], 404);
        }
        $user->delete();
        return response()->json(['message'=> 'Usuário deletado com sucesso'], 200);
    }
}
