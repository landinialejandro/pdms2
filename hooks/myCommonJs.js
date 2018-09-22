/* global $j */

function show_error(field, campo, msg){
	modal_window({
		message: '<div class="alert alert-danger">' + msg + '</div>',
		title: 'Error en ' + campo,
		close: function(){
			$j('#' + field).parents('.form-group').addClass('has-error');
			$j('#' + field).focus();
		}
	});
	
	return false;
}
function show_warning(field, campo, msg){
	modal_window({
		message: '<div class="alert alert-warning">' + msg + '</div>',
		title: 'Atencion en ' + campo,
		close: function(){
			$j('#' + field).parents('.form-group').addClass('has-error');
			$j('#' + field).focus();
		}
	});
	
	return false;
}
function addWarningBtn(field, title = "Warning"){
    var oldhtml='';
    var newhtml='';
    oldhtml = $j('#' + field ).closest('div').html();
    newhtml =   '<div class="input-group">' + oldhtml +
                        '<span class="input-group-btn">'+
                            '<button class="btn btn-default btn-fix" myfield="'+ field +'" type="button" title="'+ title +'"><span class="glyphicon glyphicon-ok"></span></button>'+
                        '</span>'+
                '</div>';
    $j('#' + field ).closest('div').html(newhtml);
}

function ToggleFix (field, a = 'default'){
    
    if (!$j('#' + field).next().children('.btn-fix').hasClass('btn-' + a)){

        $j('#' + field).next().children('.btn-fix').toggleClass('btn-' + a);

        if (a === 'default'){
            $j('#' + field).next().children('.btn-fix').children().toggleClass('glyphicon-ok');
             $j('#' + field).next().children('.btn-fix').removeClass('btn-warning, btn-danger');
             $j('#' + field).next().children('.btn-fix').children().removeClass('glyphicon-warning-sign, glyphicon-remove ');
             $j('#' + field).parents('.form-group').removeClass('has-error');
        };
        if (a === 'warning'){
            $j('#' + field).next().children('.btn-fix').children().toggleClass('glyphicon-warning-sign');
             $j('#' + field).next().children('.btn-fix').removeClass('btn-default');
             $j('#' + field).next().children('.btn-fix').children().removeClass('glyphicon-ok');
        };
        if (a === 'danger'){
            $j('#' + field).next().children('.btn-fix').children().toggleClass('glyphicon-remove');
             $j('#' + field).next().children('.btn-fix').removeClass('btn-default');
             $j('#' + field).next().children('.btn-fix').children().removeClass('glyphicon-ok');
        };
    }
}

function is_add_new(){
    var add_new_mode = (!$j('input[name=SelectedID]').val());
    return add_new_mode;
};

function getNumbers(inputString){
    var regex=/\d+\.\d+|\.\d+|\d+/g, 
        results = [],
        n;

    while(n = regex.exec(inputString)) {
        results.push(parseFloat(n[0]));
    }
    return results;
}

function showCard(field, dest, cmd){
    //field = field to get the ID from
    //dest = where to put the html result
    //cmd = comand for ajax and ajax file name
    var Data = $j('#' + field + '-container').select2("data");
    var id = parseInt(Data.id);
    if (id >0){
        $j.ajax({
            method: 'post', //post, get
            dataType: 'html', //json,text,html
            url: 'hooks/' + cmd + '.php',
            cache: 'false',
            data: {id: id, cmd: cmd}
        })
        .done(function (msg) {
            //function at response
            $j("#" + dest).html(msg);
            $j("#" + dest).show();
        });
    }
}

function showParent(Data){
    var parent_id = parseInt(Data.attributes.myid.value);
    var pt = Data.attributes.pt.value;
    var title = Data.attributes.title.value;
    modal_window({
            url: pt + '_view.php?Embedded=1&SelectedID=' + encodeURIComponent(parent_id),
            close: function(){
                    var field_id = $j('#' + pt + '_view_parent').prevAll('input:hidden').eq(0).attr('id');
                    $j('#' + field_id + '-container').select2('focus').select2('focus');
            },
            size: 'full',
            title: title
    });
}