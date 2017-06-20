var numberFormat = function(number) {
    return "R$ " + parseFloat(number).toFixed(2).replace(".", ",");
};

var verificarCamposForm = function(form) {
    var name;
    var existeCampoVazio = false;

    // pegandos todos os campos do form
    var campos = [];
    campos.push(form.find("div input"));
    campos.push(form.find("div select"));
    campos.push(form.find("div textarea"));
    campos.push(form.find("div checkbox"));
    campos.push(form.find("div radio"));

    campos.push(form.find("input"));
    campos.push(form.find("select"));
    campos.push(form.find("textarea"));
    campos.push(form.find("checkbox"));
    campos.push(form.find("radio"));

    $.each(campos, function(key, value) {

        $.each(campos[key], function(k, v){
            var $this = $(this);
            if ($this.prop("required") && $this.val() === "") {
                name = (v.name != "" && v.name !== undefined) ? v.name.replace("-", " ") : $this.attr("id");
                existeCampoVazio = true;
                return false;
            }
        });
        
        //if(existeCampoVazio) return false;
    });
    return (existeCampoVazio) ? 
    {
        existeCampoVazio: true,
        mensagem: "O campo '" + name + "' é obrigatório!"
    } 
        : 
    {
        existeCampoVazio: false,
    };
};

var siteUrl = function(){
    //var regexp = /^[a-z]{4,5}[:\/\/].+.com[\.a-z]{0,4}\//;
    //return regexp.exec(window.location.href)[0];
    return window.location.origin + "/";
};

var ucFirst = function(string){
    return string[0].toUpperCase() + string.toLowerCase().slice(1);
}