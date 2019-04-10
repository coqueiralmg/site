<div class="modal fade" id="modal_relacionamento_legislacao" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title">Buscar Legislação a Relacionar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group label-control">
                            <?= $this->Form->label("titulo", "Legislação") ?>
                            <?= $this->Form->text("titulo", ["id" => "titulo", "class" => "form-control"]) ?>
                            <span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-2" style="padding-top: 38px">
                        <button id="buscar" type="button" class="btn btn-success pull-right">Buscar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="card-content table-responsive">
                            <h4 class="card-title">Digite os campos acima para buscar</h4>
                            <p class="category"></p>
                            <table id="tabela" class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Número</th>
                                        <th>Título</th>
                                        <th style="width: 18%">Data</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="pivot" style="display: none">
                                    <tr id="">
                                        <td id="numero"></td>
                                        <td id="titulo"></td>
                                        <td id="data"></td>
                                        <td id="botoes" class="td-actions text-right" style="width: 12%">
                                            <button type="button" class="btn btn-success btn-round" onclick="relacionar(this)" data-dismiss="modal"><i class="material-icons">done</i></button>
                                        </td>
                                    </tr>
                                    <tr colspan="3">
                                        <td>
                                            <p>Dados não encontrados. Verifique se a legislação realmente existe ou está cadastrado no sistema.</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody id="data">
                                    <tr colspan="4">
                                        <td>
                                            <p>Digite as informações acima para buscar.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button id="btnFechaModalMedico" type="button" class="btn btn-danger btn-simple"  data-dismiss="modal">Fechar<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 50.5833px; top: 23px; background-color: rgb(244, 67, 54); transform: scale(8.51042);"></div></div></button>
            </div>
        </div>
    </div>
</div>
