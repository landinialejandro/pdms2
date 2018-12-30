		<?php
				$options = array("Contacts","Companies","Addresses","Phones","Mails","Products","Documents","Attributes","Orders","Taxes","CashNote","sdi-CodiceDestinatario","sdi-RegimeFiscale","sdi-TipoCassa","sdi-ModalitaPagamento","sdi-Natura");
			
				//convert options to select2 format
				$optionsList = array();
				for ($i = 0; $i < count($options); $i++) {
					$optionsList[] = (object) array(
						"id" => $i,
						"text" => $options[$i]
					);
				}
				$optionsList = json_encode($optionsList);
                                
				//convert value to select2 format
                                $FilterValue=$_REQUEST['FilterValue'];
				if ($FilterValue[1]) {
					$filtervalueObj = new stdClass();
					$text = htmlspecialchars($FilterValue[1]);
					$filtervalueObj->text = $text;
					$filtervalueObj->id = array_search($text, $options);

					$filtervalueObj = json_encode($filtervalueObj);
				}

			?>	
<div id="kinds-search" class="row" hidden="">
    <div class="col col-lg-6 vspacer-lg">
		<div class="hidden-xs hidden-sm col-lg-6 vspacer-lg text-right"><label for="">Entity search</label></div>
				
		<div class="col-lg-6 vspacer-md">	
			<div id="1_DropDown"><span></span></div>
		</div>
		<input type="hidden" class="populatedOptionsData" name="1" value="<?php echo htmlspecialchars($FilterValue[1]); ?>" >
		<input type="hidden" name="FilterAnd[1]" value="and">
		<input type="hidden" name="FilterField[1]" value="1">
                <!-- cahngue operator to like for multiple select -->
		<input type="hidden" name="FilterOperator[1]" value="like">
		<input type="hidden" name="FilterValue[1]" id="1_currValue" value="<?php echo htmlspecialchars($FilterValue[1]); ?>" size="3">
    </div>
</div>	

<script>
        var populate_1 = <?php echo $filtervalueObj ;?>		
        $j(function () {
                $j("#1_DropDown").select2({
                        data: <?php echo $optionsList; ?>})
                    .on('change', function (e) {
                        $j("#1_currValue").val(e.added.text);
                        $j("[name^=FilterValue]").val(e.added.text);
                        $j("[name^=FilterOperator]").val('like');
                        if (e.added.id ==='{empty_value}'){
                            $j("[name^=FilterOperator]").val('is-empty');
                            beforeCancelFilters();
                        }
                        $j('form').submit();
                        return true;
                });
                $j("#1_DropDown").select2("val",$j("[name^=FilterValue]").val())
                /* preserve the applied filter and show it when re-opening the filters page */
                if ($j("#1_currValue").val().length) {
                        $j("#1_DropDown").select2('data', populate_1 );
                }
                //stop event if it is already bound
                $j(".numeric").off("keydown").on("keydown", function (e) {
                        // Allow: backspace, delete, tab, escape, enter and .
                        if ($j.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                // Allow: Ctrl+A, Command+A
                                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
                                // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                        // let it happen, don't do anything
                                        return;
                        }
                        // Ensure that it is a number and stop the keypress
                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                        }
                });                
        });

        /* function to handle the action of the clear field button */
        function clearFilters(elm){
                var parentDiv = $j(elm).parent(".row ");
                //get all input nodes
                inputValueChildren = parentDiv.find("input[type!=radio][name^=FilterValue]");
                inputRadioClildren = parentDiv.find("input[type=radio][name^=FilterValue]");

                //default input nodes ( text, hidden )
                inputValueChildren.each(function( index ) {
                        $j( this ).val('');
                });

                //radio buttons
                inputRadioClildren.each(function( index ) {
                        $j( this ).removeAttr('checked');

                        //checkbox case
                        if ($j( this ).val()=='') $j(this).attr("checked", "checked").click();
                });

                //lookup and select dropdown
                parentDiv.find("div[id$=DropDown],div[id^=filter_]").select2("val", "");

                //for lookup
                parentDiv.find("input[id^=lookupoperator_]").val('equal-to');

        }

        function checkboxFilter(elm) {
                if (elm.value == "null") {
                        $j("#" + elm.className).val("is-empty");
                } else {
                        $j("#" + elm.className).val("equal-to");
                }
        }

        /* funtion to remove unsupplied fields */
        function beforeApplyFilters(event){

                //get all field submitted values
                $j(":input[type=text][name^=FilterValue],:input[type=hidden][name^=FilterValue],:input[type=radio][name^=FilterValue]:checked").each(function( index ) {

                        //if type=hidden  and options radio fields with the same name are checked, supply its value
                        if ( $j( this ).attr('type')=='hidden' &&  $j(":input[type=radio][name='"+$j( this ).attr('name')+"']:checked").length >0 ){
                                return;
                        }

                          //do not submit fields with empty values
                        if ( !$j( this ).val()){
                          var fieldNum =  $j(this).attr('name').match(/(\d+)/)[0];
                          $j(":input[name='FilterField["+fieldNum+"]']").val('');

                          };
                });

        }

        function beforeCancelFilters(){


                //other fields
                $j('form')[0].reset();

                //lookup case ( populate with initial data)
                $j(":input[class='populatedLookupData']").each(function(){


                        $j(":input[name='FilterValue["+$j(this).attr('name')+"]']").val($j(this).val());
                        if ($j(this).val()== '<None>'){
                                $j(this).parent(".row ").find('input[id^="lookupoperator"]').val('is-empty');
                        }else{
                                $j(this).parent(".row ").find('input[id^="lookupoperator"]').val('equal-to');
                        }

                })

                //options case ( populate with initial data)
                $j(":input[class='populatedOptionsData']").each(function(){

                        $j(":input[name='FilterValue["+$j(this).attr('name')+"]']").val($j(this).val());
                })


                //checkbox, radio options case
                $j(":input[class='checkboxData'],:input[class='optionsData'] ").each(function(){
                        var filterNum = $j(this).val();
                        var populatedValue = eval("filterValue_"+filterNum);                  
                        var parentDiv = $j(this).parent(".row ");

                        //check old value
                        parentDiv.find("input[type=radio][value='"+populatedValue+"']").attr('checked', 'checked').click();

                })

                //remove unsuplied fields
                beforeApplyFilters();

                return true;
        }
</script>

<style>
        .form-control{ width: 100% !important; }
        .select2-container, .select2-container.vspacer-lg{ max-width: unset !important; width: 100%; margin-top: 0 !important; }
</style>


		
