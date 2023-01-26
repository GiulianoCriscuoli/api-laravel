<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Suport\Facades\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ApiController extends Controller
{
    public function index() {

        $todos = Todo::simplePaginate(2);

        $array = ['error' => '', 'list' =>  $todos->items(), 'currentPage' => $todos->currentPage()];

        return $array;

    }

    public function store(Request $request) {

        $array = ['error' => ''];

        $rules = [
            'title' => 'required|min:3'
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if($validator->fails()) {

            $array['error'] = $validator->messages();

            return $array;

        }

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->save();

        $array = ['success' => 'Todo criado com sucesso'];

        return $array;

    }

    public function show($id) {

        $array['error'] = '';

        $todo = Todo::find($id);

        if(!$todo) {

            $array['error'] = 'Não existe o registro '.$id;

            return $array;

        }

        $array['todo'] = $todo;

        return $array;

    }

    public function update($id, Request $request) {

        $array['error'] = '';

        $todo = Todo::find($id);

        if(!$todo) {

            $array['error'] = 'Não existe o registro '.$id;

            return $array;

        }

        $rules = [
            'title' => 'required|min:3',
            'done' => 'boolean'
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if($validator->fails()) {

            $array['error'] = $validator->messages();

            return $array;

        }

        $data = $request->all();

        $todo->update([

            'title' => $data['title'],
            'done' => $data['done']
        ]);

        $array['success'] = 'Todo atualizada com sucesso';

        return $array;
    }

    public function delete($id) {

        $error['error'] = '';

        $todo = Todo::find($id);

        if(!$todo) {

            $array['error'] = 'Não existe o registro '.$id;

            return $array;

        }

        $todo->delete();

        $array['success'] = 'Todo deletado com sucesso';

        return $array;

    }
}
