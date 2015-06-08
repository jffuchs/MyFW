function changeTable($myjson)
{
	$.ajax({
            url: '/TESTE/SaveSession.php',
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