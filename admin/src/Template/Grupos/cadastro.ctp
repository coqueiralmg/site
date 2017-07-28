<?= $this->Html->script('controller/grupos.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <legend>Dados Cadastrais</legend>
                                    <div class="form-group label-control">
                                        <label>Nome</label>
                                        <input class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="funcoes" class="col-md-12">
                                    <legend>Funções</legend>
                                    <?php foreach ($grupos_funcoes as $grupo): ?>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-min">
                                                <label><?=$grupo->nome?></label> <br/>
                                                <?php foreach ($funcoes as $funcao): ?>
                                                    <?php if($funcao->grupo == $grupo->id):?>
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input type="checkbox"> <?=$funcao->nome?>
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="marcarTodos()" class="btn btn-default btn-simple">Marcar Todos<div class="ripple-container"></div></button>
                                    <button type="button" onclick="desmarcarTodos()" class="btn btn-default btn-simple">Desmarcar Todos<div class="ripple-container"></div></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <legend>Outros</legend>
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox"> Ativo
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox"> Permitir integração com outros sistemas da prefeitura
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox"> Grupo Administrativo
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success pull-right">Salvar</button>
                            <button type="reset" class="btn btn-primary pull-right">Limpar</button>
                            <button type="button" class="btn btn-primary pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>