function showMapelByKelas(kelasId,element,mapelId=0){
    $.get( "ajax/index.php?req=getMapelByKelasMengajar&kelas_id="+kelasId, function( response ) {
        var selected = '';
        var html ='<option value="">Pilih Mapel</option>';
            $.each( response.data, function( key,value ) {
                if(mapelId==value.id){
                    selected='selected';
                }else{
                    selected='';
                }
                html+='<option value="'+value.id+'" '+selected+'>'+value.nama+'</option>'
            });
            selected='';
        $(element).html(html);
    });
}

function showMapelByKelasOnly(kelasId,element,mapelId=0){
    $.get( "ajax/index.php?req=getMapelByMengajarGuru&kelas_id="+kelasId, function( response ) {
        var selected = '';
        var html ='<option value="">Pilih Mapel</option>';
            $.each( response.data, function( key,value ) {
                if(mapelId==value.id){
                    selected='selected';
                }else{
                    selected='';
                }
                html+='<option value="'+value.id+'" '+selected+'>'+value.nama+'</option>'
            });
            selected='';
        $(element).html(html);
    });
}

function showKdByMapel(mapelId,element,kdId=0){
    $.get( "ajax/index.php?req=getKdByMapel&mapel_id="+mapelId, function( response ) {
        var checked = '';
        var html ='';
            $.each( response.data, function( key,value ) {
                if(kdId==value.id){
                    checked='checked';
                }else{
                    checked='';
                }
                html+='<div class="radio" >';
                html+='<label>';
                html+='<input type="radio" name="kd_id" id="optionsRadios1" value="'+value.id+'" '+checked+' >';
                html+=value.no_kd+''+value.diskripsi_kd;
                html+='</label>';
                html+='</div>';
            });
        $(element).html(html);
    });
}

function showKdByMapelTingkat(mapelId,element,kdId=0){
    var kelasId = $("select[name='kelas_id']").val();
    $.get("ajax/index.php?req=getKelasById&kelas_id="+kelasId, function(response){
        var tingkatId = response.data.tingkat;
        $.get( "ajax/index.php?req=getKdByMapelTingkat&mapel_id="+mapelId+"&tingkat="+tingkatId, function( response ) {
            var checked = '';
            var html ='';
                $.each( response.data, function( key,value ) {
                    if(kdId==value.id){
                        checked='checked';
                    }else{
                        checked='';
                    }
                    html+='<div class="radio" >';
                    html+='<label>';
                    html+='<input type="radio" name="kd_id" id="optionsRadios1" value="'+value.id+'" '+checked+' >';
                    html+=value.no_kd+''+value.diskripsi_kd;
                    html+='</label>';
                    html+='</div>';
                });
            $(element).html(html);
        });

    });
}

function showSiswaByKelas(kelasId, element, noInduk=0){
    $.get( "ajax/index.php?req=getSiswaByKelas&kelas_id="+kelasId, function( response ) {
        var selected = '';
        var html ='<option value="">Pilih Siswa</option>';
            $.each( response.data, function( key,value ) {
                if(noInduk==value.no_induk){
                    selected='selected';
                }else{
                    selected='';
                }
                html+='<option value="'+value.no_induk+'" '+selected+'>';
                html+=value.nama;
                html+='</option>';
            });
        $(element).html(html);
    });
}