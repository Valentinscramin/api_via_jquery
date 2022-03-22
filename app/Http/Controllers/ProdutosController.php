<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Produtos;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('produtos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $produtos = new Produtos();
        $produtos->name = $request->input('name');
        $produtos->stock = $request->input('stock');
        $produtos->valor = $request->input('valor');
        $produtos->save();

        return json_encode($produtos);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $produto = Produtos::find($id);

        if ( isset($produto) )
        {
            return json_encode($produto);
        }

        return response("Produto não encontrado", 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = Produtos::find($id);

        if( isset($produto) )
        {
            $produto->name = $request->input('name');
            $produto->stock = $request->input('stock');
            $produto->valor = $request->input('valor');
            $produto->save();

            return json_encode($produto);
        }

        return response("Produto não encontrado", 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produtos::find($id);

        if(isset($produto))
        {
            $produto->delete();
            return response('OK', 200);
        }

        return response('FALSE', 404);
    }

    public function index()
    {
        $produtos = Produtos::all();
        return json_encode($produtos);
    }
}
