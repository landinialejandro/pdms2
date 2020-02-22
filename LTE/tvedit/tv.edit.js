
    var submitdata = {};

    var $type = function(fn =[] ,obj){
        var n =false;
        fn.some( function(e){
            n = obj.includes(e);
            return n;
        })
        return n? 'select':'text';
    };

    $loadurl = function(fn,tdId){
        var ret ="LTE/tvedit/tv.edit.data.php";
        if ($type(fn,tdId) != "select"){
            ret="";
        }
        return ret;
    }


    // fn =[] // fields name to add select
    function tv_editlets(tn,fn =[],def) {
        add_buttons(tn);  
        var td = $j('tr > td[id^="'+tn+'"] > a');
       
        td.each(function(){
            var tdId = $j(this).closest('td').attr('id');
            
            $j(this).prop("onclick", null).off("click")
                .removeAttr("href").css("cursor","pointer")
                .editable("LTE/tvedit/tv.edit.php", {
                    type: $type(fn,tdId),
                    loadurl : $loadurl(fn,tdId),
                    loaddata:{ t: tn, f: $get_fn(this) },
                    cancel : ' <i class="fa fa-times"></i> ',
                    cancelcssclass : 'btn btn-danger btn-xs',
                    submit : ' <i class="fa fa-check"></i> ',
                    submitcssclass : 'btn btn-success btn-xs',
                    tooltip : "Click to edit...",
                    onsubmit : function() { 
                        submitdata['tn'] = tn;
                        submitdata['id'] = $get_id(this); 
                        submitdata['fn'] = tdId; 
                    },
                    submitdata : submitdata,
                    loadtext: 'loading...'
                }
            );
        })
    };

    function add_buttons(tn){
        $j('thead tr th:first-child').css('width','80px');
        $j('tbody > tr td:first-child').each( function(){
            //console.log(this);
            $j(this).append('<a style="color: rgba(0,0,0,.5);margin: 5px;" href="'+tn+'_view.php?SelectedID='+this.firstElementChild.value+'"><i class="fa fa-edit"></i></a>');
        })
    };

    $get_id = function (e){
        id = $j(e).closest('tr').attr('data-id');
        if (!id){
            s = $j(e).closest('td').attr('id').split("-");
            id = s[2];
        }
        return id;
    }
    $get_fn = function(e){
        s = $j(e).closest('td').attr('id').split("-");
        return s[1];
    }