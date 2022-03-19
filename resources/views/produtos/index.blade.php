@extends('layout.app')

@section('title', 'Produtos')

@section('content')

    <div class="row">
        <div class="col-12" style="margin:10px;">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modelId" onclick="novoProduto()">
                Novo Produto
            </button>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Estoque</th>
                    <th scope="col">Valor</th>
                </tr>
                </thead>
                <tbody id="listagemProdutos">
                    
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-cadastro" id="formCadastro">
                    <div class="modal-body">

                        <input type="hidden" id="id" class="form-control">

                        <div class="mb-3">
                            <label for="nomeProduto" class="form-label">Nome do produto</label>
                            <input type="text" name="nomeProduto" id="nomeProduto" class="form-control" placeholder="" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">Digite o nome completo do produto.</small>
                        </div>

                        <div class="mb-3">
                            <label for="estoqueProduto" class="form-label">Estoque do produto</label>
                            <input type="number" name="estoqueProduto" id="estoqueProduto" class="form-control" placeholder="" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">Digite a quantidade em estoque do produto.</small>
                        </div>

                        <div class="mb-3">
                            <label for="valorProduto" class="form-label">Valor do produto</label>
                            <input type="number" name="valorProduto" id="valorProduto" class="form-control" placeholder="" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">Digite o valor do produto.</small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

@endSection

@section('javascript')
<script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : "{{ csrf_token() }}"
    }
});

function novoProduto(){
    $('#nomeProduto').val('');
    $('#estoqueProduto').val('');
    $('#valorProduto').val('');
}

$('#formCadastro').submit(function(e){
    e.preventDefault();
    criarProduto();
    $('#modelId').hide();
});


function criarProduto(){
    produto = { 
                name: $('#nomeProduto').val(), 
                stock: $('#estoqueProduto').val(), 
                valor: $('#valorProduto').val()
            };

    $.post("/api/produtos/novo", produto, function(data){
        console.log(data);
    });
}

function carregaProdutos(){
    $.getJSON('/api/produtos', function(data){
        for(i=0;i<data.length;i++)
        {
            opcao = '<tr><td>'+ data[i].id +'</td><td>'+ data[i].name +'</td><td>'+ data[i].valor +'</td></tr>';
            $('#listagemProdutos').append(opcao);
        }
    });
}


$(function(){
    carregaProdutos();
})



</script>
@endSection