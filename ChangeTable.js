function changeTable($myjson)
{
	$.ajax({url: '/TESTE/SaveSession.php',
          type: 'GET',
          dataType: 'json',
          data: $myjson
	})
    .done(function(dados) {
		location.reload();
	})
    .fail(function(jqXHR, textStatus, errorThrown) {
		console.info(jqXHR);
		console.info(textStatus);
		console.info(errorThrown);
	})
    .always(function() {
		console.log("complete");
	});
}


function resetForm(myFormId)
{
  var myForm = document.getElementById(myFormId);

  for (var i = 0; i < myForm.elements.length; i++)
  {
    if ('submit' != myForm.elements[i].type && 'reset' != myForm.elements[i].type)
    {
      myForm.elements[i].checked = false;
      myForm.elements[i].value = '';
      myForm.elements[i].selectedIndex = 0;
    }
  }
 }

function getController()
{
  return $("div[id^=index]").attr("controller");
}

var divContent = '#page-wrapper';

function changeNrLinhas($i)
{
  $(divContent).load('RouterAJAX.php', {'_controller': getController(), '_linhas': $i});
}

function changePesquisar($txt)
{
  $(divContent).load('RouterAJAX.php', {'_controller': getController(), '_pesquisa': $txt});
}

function chamarAjax($i)
{
  var nLinhas = $('#selectNrLinhas').val();
  $(divContent).load('RouterAJAX.php', {'_controller': getController(), page: $i, '_linhas': nLinhas});
}

function changeTableOrder($fieldName)
{
    var nome = $($fieldName).attr("id");

    //console.info($fieldName);
    //console.info(nome);

    var desc = $(this).attr("data_aux");
    if (desc == 'DESC') {
        desc = "ASC"
    } else {
        desc = "DESC"
    };
    $(this).attr("data_aux", desc);

    var nLinhas = $('#selectNrLinhas').val();

    $(divContent).load('RouterAJAX.php', {'_controller': getController(),
                                          '_linhas': nLinhas,
                                          '_orderBy': nome,
                                          '_orderAD': desc});
}
