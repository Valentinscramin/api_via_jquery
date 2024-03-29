@extends('layout.app')

@section('title', 'Produtos')

@section('content')

    <div class="row">
        <div class="col-12" style="margin:10px;">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modelId" id="novoProduto" onkeyup="novoProduto()">
                Novo Produto
            </button>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Estoque</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Ação</th>
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
                    <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-cadastro" id="formCadastro">
                    <div class="modal-body">

                        <input type="hidden" id="idCadastrado" class="form-control">

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
    $('#idCadastrado').val('');
    $('#nomeProduto').val('');
    $('#estoqueProduto').val('');
    $('#valorProduto').val('');
}

$('#formCadastro').submit(function(e){
    e.preventDefault();

    console.log($('#idCadastrado').val());

    if( $('#idCadastrado').val() == '')
    {
        criarProduto();
    }else{
        salvarProdutoEditado();
    }
    $('#btn-close').click();
});

function salvarProdutoEditado(){

    produto = { 
                id: $('#idCadastrado').val(),
                name: $('#nomeProduto').val(), 
                stock: $('#estoqueProduto').val(), 
                valor: $('#valorProduto').val()
            };

    $.ajax({
    method: "PUT",
    url: "/api/produtos/"+produto.id,
    context: this,
    data: produto,
    })
    .done(function( data ) {

        prod = JSON.parse(data);
        linhas = $('#listagemProdutos>tr');

        e = linhas.filter(function(i, elemento){ 
            return elemento.cells[0].textContent == prod.id; 
        });

        if (e) {
            e[0].cells[0].textContent = prod.id;
            e[0].cells[1].textContent = prod.name;
            e[0].cells[2].textContent = prod.stock;
            e[0].cells[3].textContent = prod.valor;
        }

    });
    
}

function deletaProduto(id)
{
    $.ajax({
    method: "DELETE",
    url: "/api/produtos/"+id,
    context: this,
    })
    .done(function( msg ) {
        linhas = $('#listagemProdutos>tr');
        e = linhas.filter(function(i, elemento){ 
            return elemento.cells[0].textContent == id; 
        });
        e.remove();
    });
}

function editarProduto(id)
{
    $.getJSON("/api/produtos/"+id, function(data){
        console.log(data.name);
        novoProduto();
        $('#idCadastrado').val(data.id);
        $('#nomeProduto').val(data.name);
        $('#estoqueProduto').val(data.stock);
        $('#valorProduto').val(data.valor);
        $('#novoProduto').click();
    });

}


function criarProduto(){
    produto = { 
                name: $('#nomeProduto').val(), 
                stock: $('#estoqueProduto').val(), 
                valor: $('#valorProduto').val()
            };

    $.post("/api/produtos", produto, function(data){
        produto = JSON.parse(data);
        linha = mostrarLinha(produto);
        $('#listagemProdutos').append(linha);
    });
}

function mostrarLinha(data)
{
    var linha = "<tr>"+
                "<td>"+data.id+"</td>"+
                "<td>"+data.name+"</td>"+
                "<td>"+data.stock+"</td>"+
                "<td>"+data.valor+"</td>"+
                "<td>"+"<button type='button' class='btn btn-primary' onclick='editarProduto("+data.id+")'>"+
                        "<i class='fa-solid fa-pen'></i>"+
                    "</button>"+
                    "<button type='button' class='btn btn-danger' onclick='deletaProduto("+data.id+")'>"+
                        "<i class='fa-solid fa-trash'></i>"+
                    "</button>"+
                "</td>"+
                "</tr>"

    return linha
}

function carregaProdutos(){
    $.getJSON('/api/produtos', function(data){
        for(i=0;i<data.length;i++)
        {
            linha = mostrarLinha(data[i]);
            $('#listagemProdutos').append(linha);
        }
    });
}


$(function(){
    carregaProdutos();
})



</script>
@endSection