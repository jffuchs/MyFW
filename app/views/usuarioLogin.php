<body>
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-84 col-md-offset-2">
                        <p>
                        <?php echo Alert::render(); ?>
                    </div>

                    <div class="col-md-4 col-md-offset-4">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Login</h3>
                            </div>
                            <div class="panel-body">
                                <form action="<?php echo PATH; ?>login/logar" role="form" method="post">
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" name="RegForm[ID]" placeholder="Usuário" id="ID" type="text" required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" name="RegForm[Senha]" placeholder="Senha" id="Senha" type="password" required value="">
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input name="remember" type="checkbox" value="Lembrar-me">Lembrar-me
                                            </label>
                                        </div>

                                        <button class="btn btn-lg btn-success btn-block" type="submit" value="Logar">
                                        <i class="fa fa-sign-in"></i> Entrar</button>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
