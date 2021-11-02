$(document).ready(function(){
    $('#filer_input').filer({
        limit: 10,
        maxSize: 10,
        extensions: ["jpg", "png", "gif","pdf","docx","doc","jpeg"],
        showThumbs: true,
        captions:{
            button: "Escolher arquivos",
            feedback: "Escolha arquivos para subir",
            feedback2: "Arquivos escolhidos",
            drop: "Arraste e Solte arquivos aqui",
            removeConfirmation: "Você tem certeza que deseja remover esse arquivo?",
            errors: {
                filesLimit: "O limite máximo de arquivos é {{fi-limit}}.",
                filesType: "Apenas imagens, documentos e pdf podem ser anexados",
                filesSize: "O arquivo {{fi-name}} é muito grande! Suba um arquivo com no máximo {{fi-fileMaxSize}} MB.",
                filesSizeAll: "Os arquivos que você escolheu são grandes! Escolha arquivos com no máximo {{fi-maxSize}} MB.",
                folderUpload: "Não é possível enviar pastas, apenas arquivos ."
            }
        },
        dialogs:{
            alert: function(text) {
                Swal.fire({
                    icon: 'info',                    
                    text: text,                    
                })                
            },
            confirm: function(text, callback) {
                Swal.fire({                    
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback()
                    }
                })                                
            }
        }
    });       

    $(".form-lead").submit(function(e){
        e.preventDefault();

        let textButton =  $(this).find('button[type=submit]').text();
        $(this).find('button[type=submit]').prop('disabled',true);
        $(this).find('button[type=submit]').text('Aguarde...');

        let that = this;
        let formData =  new FormData(this);
        
        let url = $(this).attr('action');
                
        $.ajax({
            url: url,
            type: 'post',
            data:formData,
            contentType: false,
            processData: false,
            success: function(response){
                response = JSON.parse(response);
                if(typeof(response.result) !== undefined){
                    if(response.result=='success'){
                        Swal.fire({
                            icon: 'success',
                            text: response.message,                    
                        }).then((result) => {
                            $(that).trigger('reset');
                            $(that).find('button[type=submit]').prop('disabled',false);
                            $(that).find('button[type=submit]').text(textButton);
                        });
                    }else{
                        Swal.fire({
                            icon: 'warning', 
                            title: "Erro",
                            text: response.message
                        }).then((result) => {
                            $(that).find('button[type=submit]').prop('disabled',false);
                            $(that).find('button[type=submit]').text(textButton);
                        });
                    }
                }else{
                    Swal.fire({
                        icon: 'warning', 
                        title: "Erro",
                        text: 'Houve um erro ao enviar sua solicitação! Tente Novamente',                    
                    }).then((result) => {
                        location.reload();
                    });
                }
            }
        });               
    });

    $(".form-newsletter").submit(function(e){
        e.preventDefault();

        let textButton =  $(this).find('button[type=submit]').text();
        $(this).find('button[type=submit]').prop('disabled',true);
        $(this).find('button[type=submit]').text('Aguarde...');

        let that = this;
        let formData = $(this).serializeArray();
        
        let url = $(this).attr('action');
                
        $.ajax({
            url: url,
            type: 'post',
            data:formData,            
            success: function(response){
                response = JSON.parse(response);
                if(typeof(response.result) !== undefined){
                    if(response.result=='success'){
                        Swal.fire({
                            icon: 'success',
                            text: response.message,                    
                        }).then((result) => {
                            $(that).trigger('reset');
                            $(that).find('button[type=submit]').prop('disabled',false);
                            $(that).find('button[type=submit]').text(textButton);
                        });
                    }else{
                        Swal.fire({
                            icon: 'warning', 
                            title: "Erro",
                            text: response.message
                        }).then((result) => {
                            $(that).find('button[type=submit]').prop('disabled',false);
                            $(that).find('button[type=submit]').text(textButton);
                        });
                    }
                }else{
                    Swal.fire({
                        icon: 'warning', 
                        title: "Erro",
                        text: 'Houve um erro ao enviar sua solicitação! Tente Novamente',                    
                    }).then((result) => {
                        location.reload();
                    });
                }
            }
        });               
    });
})
   