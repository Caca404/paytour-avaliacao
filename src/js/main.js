$(document).ready(function () {
    var maskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {
        onKeyPress: function (val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };

    $('#telefone').mask(maskBehavior, options);

});

$("form").submit(function(e){
    e.preventDefault();

    if(validateForm()) submitForm();
});

function validateForm() {

    var isValid = true;
    var commonsInputs = [
        "#nome",
        "#email",
        "#telefone",
        "#cargo",
        "#escolaridade"
    ];

    commonsInputs.forEach(input => {
        if($(input).val() == null || $(input).val().trim() == "") {
            isValid = false;
            $(input).addClass('is-invalid');
            $(input).removeClass('is-valid');
        }
        else {
            $(input).removeClass('is-invalid');
            $(input).addClass('is-valid');
        }
    });

    
    if($("#file")[0].files == undefined || !$("#file")[0].files.length){
        isValid = false;
        $("#file").addClass('is-invalid');
        $("#file").removeClass("is-valid");
        $("#invalidCurriculo").removeClass("d-none");
        $("#invalidCurriculoType").addClass("d-none");
        $("#invalidCurriculoSize").addClass("d-none");
    }
    else{
        $("#file").removeClass('is-invalid');
        $("#file").addClass("is-valid");
        $("#invalidCurriculo").addClass("d-none");

        var arquivo = $("#file")[0].files[0];
        let validMime = [
            'application/pdf', 
            'application/msword', 
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        if(!validMime.find((elem) => elem == arquivo.type)){
            isValid = false;
            $("#file").addClass('is-invalid');
            $("#file").removeClass("is-valid");
            $("#invalidCurriculoType").removeClass("d-none");
            $("#invalidCurriculoSize").addClass("d-none");
        }
        else{
            $("#file").addClass("is-valid");
            $("#file").removeClass("is-invalid");
            $("#invalidCurriculoType").addClass("d-none");            

            var size = Math.round(arquivo.size*100/Math.pow(1024, 2))/100;

            if(size > 1){
                isValid = false;
                $("#file").addClass('is-invalid');
                $("#file").removeClass("is-valid");
                $("#invalidCurriculoSize").removeClass("d-none");
            }
            else{
                $("#file").addClass("is-valid");
                $("#file").removeClass("is-invalid");
                $("#invalidCurriculoSize").addClass("d-none");
            }
        }
    }

    var inputData = new Date($('#date').val()+" "+$("#time").val());

    if(inputData == "Invalid Date" || inputData > new Date()){
        isValid = false;
        $("#date, #time").addClass('is-invalid');
        $("#date, #time").removeClass("is-valid");
    }
    else{
        $("#date, #time").removeClass('is-invalid');
        $("#date, #time").addClass("is-valid");
    }

    return isValid;
}

function submitForm(){

    dataSubmition = new FormData();
    dataSubmition.append('urlFunction', "submitForm");
    dataSubmition.append('nome', $("#nome").val().trim());
    dataSubmition.append('email', $("#email").val().trim());

    let telefoneValue = $("#telefone").val().replace(" ", "")
        .replace('(', "").replace(')', "").replace("-", "");

    dataSubmition.append('telefone', telefoneValue);
    dataSubmition.append('cargo', $("#cargo").val().trim());
    dataSubmition.append('escolaridade', $("#escolaridade option:selected").val());
    dataSubmition.append('observacoes', $("#observacoes").val().trim());
    dataSubmition.append('file', $("#file")[0].files[0]);
    dataSubmition.append('dthr', $("#date").val()+" "+$("#time").val());

    $.ajax({
        url: "route.php",
        method: 'POST',
        data: dataSubmition,
        dataType: 'json',
        processData: false,
        contentType: false
    }).done(function(data) {

        if (data.status == 200) {

            Swal.fire({
                text: 'Salvo dos favoritos',
                target: '#custom-target',
                icon: "success",
                customClass: {
                    container: 'position-absolute'
                },
                toast: true,
                position: 'bottom-left',
                timer: 1500
            });
        } else {
            Swal.fire({
                text: 'Algo deu errado no controller ou banco',
                target: '#custom-target',
                icon: "error",
                customClass: {
                    container: 'position-absolute'
                },
                toast: true,
                position: 'bottom-left',
                timer: 3000
            });
        }

    }).fail(function(jqXHR, textStatus) {
        Swal.fire({
            text: 'Algo deu errado no controller ou banco',
            target: '#custom-target',
            icon: "error",
            customClass: {
                container: 'position-absolute'
            },
            toast: true,
            position: 'bottom-left',
            timer: 1500
        });
    });
}