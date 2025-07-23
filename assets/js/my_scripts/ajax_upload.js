
    // Variable to store your files
    var ajax_upload = {

        files:null,
        form_id:new Array(),
        loader_id:new Array(),
        content_id:new Array(),
        notify_id:new Array(),

        prepare_upload:function(event,permitted,maxsize){
            this.files = event.target.files;

            if(permitted.indexOf(this.files[0].type)<0)
            {
                alert("File tidak sesuai format!");
                $(':file').val('');
            }else{
                if(this.files[0].size > parseInt(maxsize)){
                    alert("File terlalu besar");
                    $(':file').val('');  
                }
            }
        },

        upload_files:function(event,i){
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(this.files, function(key, value)
            {
                data.append(key, value);
            });

            that=this;
            $.ajax({
                url: $('#'+this.form_id[i]).attr('action')+'?files',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                beforeSend:function(){
                    if(that.loader_id[i]!='')
                        $('#'+that.loader_id[i]).show();
                },            
                success: function(data, textStatus, jqXHR)
                {                    

                    if(typeof data.error === 'undefined')
                    {                        
                        // Success so call function to process the form
                        that.submit_form(data,i);
                    }
                    else
                    {
                        // Handle errors here
                        if(that.loader_id[i]!='')
                            $('#'+that.loader_id[i]).hide();

                       
                        $('#'+that.notify_id[i]).html(data);
                        $('#'+that.notify_id[i]).show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    if(that.loader_id[i]!='')
                        $('#'+that.loader_id[i]).hide();

                    $('#'+that.notify_id[i]).html('gagal menunggah file!');
                    $('#'+that.notify_id[i]).show();
                }
            });    
        },

        submit_form:function(data,i)
        {
            // Create a jQuery object from the form
            $form = $('#'+this.form_id[i]);            

            // Serialize the form data
            var formData = $form.serialize();
                        
            // You should sterilise the file names
            $.each(data.files, function(key, value)
            {
                formData = formData + '&filename=' + value;
            });

            that = this;


            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                cache: false,
                dataType: 'html',
                success: function(data, textStatus, jqXHR)
                {
                    error=/ERROR/;

                    console.log(data);
                    
                    if(data=='failed' || data.match(error))
                    {
                        // Handle errors here
                        if(that.loader_id[i]!='')
                            $('#'+that.loader_id[i]).hide();

                        err_msg = (data=='failed'?'gagal mengunggah file':data);
                        
                        $('#'+that.notify_id[i]).html(err_msg);
                        $('#'+that.notify_id[i]).show();
                    }
                    else
                    {
                        // Success so call function to process the form                        
                        if(that.content_id[i]!='')                        
                            $('#'+that.content_id[i]).html(data);                        
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    if(that.loader_id[i]!='')
                        $('#'+that.loader_id[i]).hide();
                    
                    $('#'+that.notify_id[i]).html('gagal menunggah file!');
                    $('#'+that.notify_id[i]).show();
                },
                complete:function(){                
                    if(that.loader_id[i]!='')
                        $('#'+that.loader_id[i]).hide();                        
                }            
            });
        }
    };