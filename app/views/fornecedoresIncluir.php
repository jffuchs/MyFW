<div class="container-fluid">
    <div class="row">
        <p>
        <?php echo Alert::render(); ?>

        <?php echo HtmlUtils::BreadCrumbs('Editar', 'Fornecedores', $view_linkCancelar, $view_get["ID"]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Informe os dados do Fornecedor</strong>
            </div>
        <div class="panel-body">

        <form action="<?php echo PATH; ?>fornecedores/gravar" id="formFor" role="form" method="post">
            <div class="form-group">
                <label for="Nome">Nome do Fornecedor</label>
                <input type="text" name="RegForm[Nome]" class="form-control" id="Nome" autofocus required value="<?php echo $view_get["Nome"]; ?>">
            </div>

            <div class="form-group">
                <label for="Celular">Celular</label>
                <input type="text" name="RegForm[Celular]" class="form-control" id="Celular" required value="<?php echo $view_get["Celular"]; ?>">
            </div>

            <div>
                <input type="hidden" name="RegForm[ID]" value="<?php echo $view_get["ID"]; ?>">
                <input type="hidden" name="acao" value="<?php echo $view_acao; ?>" />
                <input name="reset" type="reset" class="btn btn-danger" value="Limpar" onclick="resetForm('formFor'); return false;" />
                <input class="btn btn-success pull-right" type="submit" value="Salvar">
                <a class="btn btn-default" href="<?php echo $view_linkCancelar; ?>">Cancelar</a>
            </div>
        </form>
        </div>
    </div>
</div>
