<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Usuario;
use App\Http\Requests\UsuarioRequest;
use App\Exceptions\CollectionException;
use App\Http\Resources\UsuarioResource;
use App\Http\Resources\UsuarioCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsuarioController extends Controller
{
    public function all()
    {
        try {
            $usuarios = Usuario::all();

            if (!$usuarios) throw new CollectionException('No se han encontrado usuarios');

            return UsuarioCollection::make($usuarios);
            // return response()->json($usuarios);
        } catch (CollectionException $e) {
            $this->jsonFailure($e->getMessage());
        } catch (\Exception $e) {
            return $this->jsonFailure($e->getMessage());
        }
    }

    public function store(UsuarioRequest $request)
    {
        try {
            $usuario = Usuario::create([
                'uid'           =>  Uuid::uuid4()->toString(),
                'first_name'    =>  $request->first_name,
                'last_name'     =>  $request->last_name,
                'email'         =>  $request->email,
                'password'      =>  bcrypt($request->password),
                'address'       =>  $request->address,
                'phone'         =>  $request->phone,
                'phone_2'       =>  $request->phone_2,
                'postal_code'   =>  $request->postal_code,
                'birth_date'    =>  $request->birth_date,
                'gender'        =>  $request->gender,
            ]);

            if (is_null($usuario)) throw new ModelNotFoundException('El usuario no se ha podido crear');

            $usuario = new UsuarioResource($usuario);

            return $this->jsonSuccess('creado', $usuario);
        } catch (ModelNotFoundException $e) {
            return $this->jsonFailure($e->getMessage());
        } catch (\Exception $e) {
            return $this->jsonFailure($e->getMessage());
        }
    }

    public function update(UsuarioRequest $request, int $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);

            $usuario->update([
                'first_name'    =>  $request->first_name,
                'last_name'     =>  $request->last_name,
                'email'         =>  $request->email,
                'password'      =>  bcrypt($request->password),
                'address'       =>  $request->address,
                'phone'         =>  $request->phone,
                'phone_2'       =>  $request->phone_2,
                'postal_code'   =>  $request->postal_code,
                'birth_date'    =>  $request->birth_date,
                'gender'        =>  $request->gender,
            ]);

            return $this->jsonSuccess('actualizado', $usuario);
        } catch (ModelNotFoundException $e) {
            return $this->jsonFailure($e->getMessage());
        } catch (\Exception $e) {
            return $this->jsonFailure($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);

            $usuario->delete($usuario);

            return $this->jsonSuccess('eliminado');
        } catch (ModelNotFoundException $e) {
            return $this->jsonFailure($e->getMessage());
        } catch (\Exception $e) {
            return $this->jsonFailure($e->getMessage());
        }
    }
}
