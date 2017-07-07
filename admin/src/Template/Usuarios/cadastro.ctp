<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <form>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group label-control">
                                        <label>Nome</label>
                                        <input class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control input-group date">
                                        <label>Data de Nascimento</label>
                                        <input id="data_nascimento" class="form-control" type="date">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <label>E-mail</label>
                                        <input class="form-control" type="email">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Usuário</label>
                                        <input class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input class="form-control" type="password">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Confirme a Senha</label>
                                        <input class="form-control" type="password">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Grupo de Usuários</label> <br/>
                                        <select class="form-control" data-style="select-with-transition" title="Choose City" data-size="7" tabindex="-98">
                                            <option value="2"></option>
                                            <option value="3">Administrador</option>
                                            <option value="4">Gerente</option>
                                            <option value="4">Comunicação</option>
                                            <option value="4">Compras</option>
                                            <option value="4">Jurídico</option>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox"> Ativo
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox"> Obrigar o usuário a trocar de senha
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
<script type="text/javascript">
    $(function () {
        $('#data_nascimento').datepicker({
            language: 'pt-BR'
        });

        $('#data_nascimento').mask('00/00/0000');
    });

</script>