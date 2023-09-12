<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UsuarioRequest;
use App\Exceptions\CollectionException;
use App\Http\Resources\UsuarioResource;
use App\Http\Resources\UsuarioCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsuarioController extends Controller
{
    /**
     * Obtiene la coleccion de Usuarios y retorna en formato JSON.
     * Caso contrario retorna un error y guarda el Log
     *
     * @return JsonResponse|ResourceCollection
     */
    public function all(): JsonResponse|ResourceCollection
    {
        try {
            // Obtiene la coleccion de Usuarios
            $usuarios = Usuario::all();

            // Si no existe arroja un error
            if (!$usuarios) throw new CollectionException('No se han encontrado usuarios');

            // Retorna la respuesta en formato Json
            return UsuarioCollection::make($usuarios);
            // return response()->json($usuarios);
        } catch (CollectionException $e) {
            // Obtiene el error y guarda en log + retorna error
            return $this->jsonFailure($e->getMessage());
        } catch (\Exception $e) {
            // Obtiene el error y guarda en log + retorna error
            return $this->jsonFailure($e->getMessage());
        }
    }

    /**
     * Crear un Usuario
     *
     * @param UsuarioRequest $request
     * @return JsonResponse
     */
    public function store(UsuarioRequest $request): JsonResponse
    {
        try {
            // Crea al Usuario
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

            // Si el Usuario creado no existe, arrojamos un error
            if (is_null($usuario)) throw new ModelNotFoundException('El usuario no se ha podido crear');

            // Creamos una instancia en formato Json
            $usuario = new UsuarioResource($usuario);

            // Retorna respuesta en Json + Payload
            return $this->jsonSuccess('creado', $usuario);
        } catch (ModelNotFoundException $e) {
            // Obtiene el error y guarda en log + retorna error
            return $this->jsonFailure($e->getMessage());
        } catch (\Exception $e) {
            // Obtiene el error y guarda en log + retorna error
            return $this->jsonFailure($e->getMessage());
        }
    }

    /**
     * Actualiza el registro de un Usuario
     *
     * @param UsuarioRequest $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(UsuarioRequest $request, int $id): JsonResponse
    {
        try {
            // Obtiene al usuario por Id, si no lo encuentra arroja un error
            $usuario = Usuario::findOrFail($id);

            // Actualiza al Usuario
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

            // Retorna una respuesta Json
            return $this->jsonSuccess('actualizado', $usuario);
        } catch (ModelNotFoundException $e) {
            // Obtiene el error y guarda en log + retorna error
            return $this->jsonFailure($e->getMessage());
        } catch (\Exception $e) {
            // Obtiene el error y guarda en log + retorna error
            return $this->jsonFailure($e->getMessage());
        }
    }

    /**
     * SoftDeletea el registro de un Usuario
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            // Obtiene al usuario por Id, si no lo encuentra arroja un error
            $usuario = Usuario::findOrFail($id);

            // SoftDeletea a un Usuario
            $usuario->delete($usuario);

            // Retorna una respuesta Json
            return $this->jsonSuccess('eliminado');
        } catch (ModelNotFoundException $e) {
            // Obtiene el error y guarda en log + retorna error
            return $this->jsonFailure($e->getMessage());
        } catch (\Exception $e) {
            // Obtiene el error y guarda en log + retorna error
            return $this->jsonFailure($e->getMessage());
        }
    }
}
