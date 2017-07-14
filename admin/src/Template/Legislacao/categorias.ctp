<!-- Sart Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 5000">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="material-icons">clear</i>
				</button>
                <h4 class="modal-title">Nova Categoria</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group label-control">
                                <label>Nome</label>
                                <input id="titulo" class="form-control" type="text">
                                <span class="material-input"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-control">
                                <label>Ordem</label>
                                <input id="titulo" class="form-control" type="number">
                                <span class="material-input"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success btn-simple">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--  End Modal -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <button type="submit" class="btn btn-fill btn-warning pull-right" data-toggle="modal" data-target="#myModal">Novo<div class="ripple-container"></div></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <h4 class="card-title">Categorias da Legislação</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Ordem</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Geral</td>
                                    <td>3</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Tributário</td>
                                    <td>1</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Comercial</td>
                                    <td>2</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Lei Orgânica</td>
                                    <td>2</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Posses</td>
                                    <td>2</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Habitação</td>
                                    <td>2</td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_paginate paging_full_numbers" id="datatables_info">5 itens encontrados</div>
                                </div>
                                <div class="col-sm-7 text-right">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>