<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <form>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group label-control">
                                        <label>Nome</label>
                                        <input class="form-control" type="text">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
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

                            <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
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
        $('#data_nascimento').datetimepicker({
            locale: 'pt-br'
        });
    });

</script>