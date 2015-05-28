<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filtrar {NOME_LISTA}</h4>
      </div>
      <form class="form" action="{PAGE_LISTA}" method="post">
      <div class="modal-body"> 
        {FILTRO_CAMPOS}     	        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Filtrar</button>
      </div>
  	  </form>
    </div>
  </div>
</div>
