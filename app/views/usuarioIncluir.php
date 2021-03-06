<div class="container-fluid">
    <div class="row">
        <p>
        <?php echo Alert::render(); ?>

        <?php echo HtmlUtils::BreadCrumbs('Editar', 'Usuários', $view_linkCancelar, $view_get["ID"]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Informe os dados do Usuário</strong>
            </div>
        <div class="panel-body">

        <form action="<?php echo PATH; ?>usuario/gravar" id="formUsu" role="form" method="post">
            <div class="form-group">
                <label for="Nome">Nome do Usuário</label>
                <input type="text" name="RegForm[Nome]" class="form-control" id="Nome" autofocus required value="<?php echo $view_get["Nome"]; ?>">
            </div>

            <div class="form-group">
                <label for="Apelido">Apelido</label>
                <input type="text" name="RegForm[Apelido]" class="form-control" id="Apelido" required value="<?php echo $view_get["Apelido"]; ?>">
            </div>

            <div class="form-group">
                <label for="Senha">Senha</label>
                <input type="password" name="RegForm[Senha]" class="form-control" id="Senha" required value="<?php echo $view_get["Senha"]; ?>">
            </div>

            <?php if (Session::getFrom('Login','ADMIN') > 0): ?>
            <div class="form-group">
                <label>
                <input type="checkbox" name="RegForm[ADMIN]" id="ADMIN" <?php echo $view_get["ADMIN"] == 1 ? "checked" : NULL; ?>> Administrador
                </label>
            </div>
            <?php endif; ?>

            <div>
                <input type="hidden" name="RegForm[ID]" value="<?php echo $view_get["ID"]; ?>">
                <input type="hidden" name="acao" value="<?php echo $view_acao; ?>" />
                <input name="reset" type="reset" class="btn btn-danger" value="Limpar" onclick="resetForm('formUsu'); return false;" />
                <input class="btn btn-success pull-right" type="submit" value="Salvar">
                <a class="btn btn-default" href="<?php echo $view_linkCancelar; ?>">Cancelar</a>
            </div>
        </form>
        </div>
    </div>
</div>
