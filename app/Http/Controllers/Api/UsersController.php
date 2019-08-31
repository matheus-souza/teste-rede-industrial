<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Lista usuários
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    /**
     * Retorna um usuário especifico
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Cria um usuário
     *
     * @param Request $request
     * @return UserResource
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'telefone' => 'required',
        ]);

        return new UserResource(User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
        ]));
    }

    /**
     * Atualiza um usuário especifico
     *
     * @param User $user
     * @param Request $request
     * @return UserResource
     */
    public function update(User $user, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
        ]);

        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Deleta usuário especifico
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, 204);
    }
}
