<!-- Sart Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 5000">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="material-icons">clear</i>
				</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind
                    texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.
                    A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a
                    paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful
                    Pointing has no control about the blind texts it is an almost unorthographic life One day however a small
                    line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-simple">Nice Button</button>
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Close</button>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Geral</td>
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