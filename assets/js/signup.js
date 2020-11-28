window.onload = function(){
    $("#pass").bind('keyup', function(){
        var txt = $(this).val();
        var power = 0;
        var powerTxt = '';
        if(txt.length >=6){
            power +=25;
        }

        var regen = new RegExp(/[a-z]/);
        if(regen.test(txt)){
            power +=25;
        }

        var regen = new RegExp(/[0-9]/i);
        if(regen.test(txt)){
            power+=25;
        }

        var regen = new RegExp(/[^0-9a-z]/i);
        if(regen.test(txt)){
            power+=25;
        }

        var regen = new RegExp(/[A-Z]/);
        if(regen.test(txt)){
            power+=25;
        }
        
        $("#security").css("font-size", '12px');
        $("#security").css("border-radius", '0.1em');
        $("#security").css("padding-top", '5px');
        $("#security").css("width", '304.5px');
        $("#security").css("font-weight", 'bold');
        if($('#pass').val()==''){
            powerTxt = '';
            $("#security").css("background-color", 'red');
            $("#security").hide("slow");
        }else {
            $('#security').show(250);
        }  
        
        if(power <=25){
            powerTxt = 'Muito fraca';
            $("#security").css("background-color", 'red');
        } else if (power <=50){
            powerTxt = "Fraca";
            $("#security").css("background-color", 'orange');
        } else if (power <=75){
            powerTxt = "Média";
            $("#security").css("background-color", 'yellow');
        } else if(power <=100) {
            powerTxt = "Forte";
            $("#security").css("background-color", 'blue');
        } else {
            powerTxt = "Muito forte";
            $("#security").css("background-color", '#08F720');
        }

        $('#security').html("Força da senha: "+powerTxt);
        
    });
}