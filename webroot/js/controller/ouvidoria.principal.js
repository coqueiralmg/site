function enviarMensagem() {
    var response = grecaptcha.getResponse(); 

    if(response == null || response == ""){
       swal(
           'Atenção',
           'Por favor, prove à Prefeitura de Coqueiral de que você não é um robô.',
           'warning'
       );	

       return false;
    }

    return true;
}

function onSubmit(token)
{
    document.getElementById("main-contact-form").submit();	
}