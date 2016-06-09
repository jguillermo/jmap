//block box
(function( $ ){

  var methods = {
     block : function( options ) {
		
		var p = { 
			css:{
				position        : "absolute",
				left            : "0",
				top             : "0",
				right           : "0",
				bottom          : "0",
				zIndex          : "1000",
				backgroundColor : "#E2E2E2",
				cursor          : "wait",
				margin          : "0",
				padding         : "0",
				opacity         : "0.8"
			},
			wait       : false
		};
		p=$.extend(p,options);
        return this.each( function(){

			var $e = $(this);

			//$e.height(150);

			$e.css('position','relative');
			$e.find('div.blockpluginjj').remove();
			var $div=$('<div class="blockpluginjj"></div>');
			$div.css(p.css);
			if(p.wait){
				var fax=5;
				if($e.height()<120){fax=4;}
				if($e.height()< 100) {fax=3;}
				if($e.height()< 50) {fax=2;}
				if($e.height()< 25) {fax=1;}
				$div.html('<table style="height: 100%;width: 100%;text-align: center; "><tr><td><i class="fa fa-spinner fa-pulse fa-'+fax+'x"></i></td></tr></table>');
			
			}
			$e.append($div);

		});  
     },
     destroy : function( ) {
        return this.each( function(){
			var $e = $(this);
			$e.css('position','');
			$e.find('div.blockpluginjj').remove();
		});

     }
  };

  $.fn.divblockjj = function( method ) {
    
    if ( methods[method] ) {
      return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.block.apply( this, arguments );
    } else {
      $.error( 'El metodo ' +  method + ' no existe' );
    }    
  
  };
})( jQuery );


//ini
var jj = {};
(function( $ ){
	var numId=1;
	var ismobile;
	jj.help=function(){
		//console.log(jj);
	}
	jj.getId=function(){
		return numId++;
	}

	jj.isMobile=function(){
		if(typeof ismobile == "undefined"){
			var device = navigator.userAgent;
			ismobile= (device.match(/Iphone/i)|| device.match(/Ipod/i)|| device.match(/Android/i)|| device.match(/J2ME/i)|| device.match(/BlackBerry/i)|| device.match(/iPhone|iPad|iPod/i)|| device.match(/Opera Mini/i)|| device.match(/IEMobile/i)|| device.match(/Mobile/i)|| device.match(/HTC/i)? true:false);
		}
		return ismobile;
	}

})( jQuery );

// scroll
(function($) {

    var bodysc = '';
    var htmlsc = '';

    var c = {
        ini: function() {
            if (typeof bodysc == "string") {
                bodysc = $('body');
                htmlsc = $('html');
            }
        },
        move_animate: function(val, time) {
            //bodysc.scrollTop(val);

            bodysc.animate({
                scrollTop: val
            }, time);
            //$('html, body').animate({scrollTop:val},1500);
        },
        move: function(val) {
            bodysc.scrollTop(val);
            htmlsc.scrollTop(val);
        },
        get_val: function(obj) {
            var e;
            var val = 0;
            if (typeof obj == "number") {
                val = obj;
            } else {
                if (typeof obj == "string") {
                    e = $(obj);
                }
                if (typeof obj == "object") {
                    e = obj;
                }
                if (e.length > 0) {
                    val = e.position().top;
                }
            }
            return val;
        }

    }

    jj.scroll = function(obj, add) {
        c.ini();
        var v = c.get_val(obj);
        if (typeof add == "undefined") {
            add = 0;
        }
        v += add;
        c.move_animate(v, 1500);
    }

    jj.scroll_only = function(obj, add) {
        c.ini();
        var v = c.get_val(obj);
        if (typeof add == "undefined") {
            add = 0;
        }
        v += add;
        c.move(v);
    }


    //toolsjj.scroll($('#titulosperfildiv').position().top+506 );

})(jQuery);




// base url
(function( $ ){
	
	var c_jj={
		site_url:'',
		set_url:function(site){
			var ini2=site.length
			if(site.substring(ini2-1,ini2)!='/'){
				site=site+'/';
			}
			this.site_url=site;
			return true;

		},
		get_site_url:function(ruta){
			if(ruta.substring(0,1)=='/'){
				ruta=ruta.substring(1);
			}
			return this.site_url+ruta;
		}
	}
	
	jj.url=function(ruta){
		if(typeof ruta=='undefined'){ruta='';}
		return c_jj.get_site_url(ruta);
		
	}

	jj.url.setUrl=function(site){
		if(typeof site=='undefined'){site='';}
		return c_jj.set_url(site);	
	}

})( jQuery );







//filter
(function( $ ){
	
	var c_jj={

		filtro:function(plantilla,data){ // al data se muestra sol ocnolos datos de la plantilla, no se agregan mas campos a la plantilla

			$.each(plantilla, function(index, row) { 
				if(data[index]){
					if(typeof row == "object"){
						plantilla[index]=c_jj.filtro(row,data[index]);
					}else{
						plantilla[index]=data[index];
					}
				}
			});
			return plantilla;

		},
		extend:function(plantilla,data){ // agrega, modifica los campos de l aplantilla con respenctoa los datos creados
			

			////console.log("-----------------FUNCTION--------------------------------------------------------------------------");
			////console.log('0');
			$.each(data, function(index, row) { 
				////console.log("------------------------------EACH-----------------------------------------------------------");
				////console.log(plantilla);
				////console.log(row);	
				////console.log(index +' : '+row+ ' --- '+ typeof index +' : '+ typeof row);

				////console.log($.isArray(row));

				////console.log('index - '+index);
				if(typeof row == "object"){
					////console.log('1');
					
					if(typeof plantilla[index]=="undefined"){ // si no existe se crea uno nuevo
						plantilla[index]=row;
						////console.log('2');
					}else{
						////console.log('3');
						if($.isArray(row)){
							////console.log('4');
							/////////plantilla[index]=c_jj.extend(plantilla[index],row);
						}else{
							////console.log('5');
							plantilla[index]=c_jj.extend(plantilla[index],row);
						}
					}
				}else{
					////console.log('6');
					plantilla[index]=row;
				}


			});
			////console.log('7');
			return plantilla;

		}

		


	}
	
	jj.extend=function(plantilla,data){

		return c_jj.extend(plantilla,data);

	}

	jj.extend.filtro=function(plantilla,data){

		return c_jj.filtro(plantilla,data);

	}

})( jQuery );



//build form
(function( $ ){

	var printXtype={
		fieldset:function(data,size_label,size_input){

			////console.log(data);

			var d=$.extend({
				xtype:'fieldset',
				disabled:false,
				legent_align:'center',
				legent_label:'',
				legent_attr:{},
				attr:{}
			},data);

			console.log(d);


			size_label=$.extend({
					xs:12,sm:3,md:3,lg:3
			},size_label);

			size_input=$.extend({
					xs:12,sm:9,md:9,lg:9
			},size_input);

			//console.log(1);
			var txtdisable=(d.disabled)? "disabled":"";
			var borderclass=(d.legent_label=="")? "":"formjjborder";

			var e='<fieldset class="'+borderclass+'" '+txtdisable+' ';
 
    			$.each(d.attr, function(index, row) { 
						e+=index+'="' + row + '" ';
				});
				e+=" >";
				
				

				if(d.legent_label!=""){
					//console.log(3.1);
					 e+='<legend align="'+d.legent_align+'" ';

					 $.each(d.legent_attr, function(index, row) { 
					 	e+=index+'="' + row + '" ';
					 });
					
					 e+=' >'+d.legent_label+'</legend>';

				}
				if(typeof d.items !="undefined"){

					$.each(d.items, function(index, row) { 
					
						if(typeof row.xtype!="undefined"){
							if(row.xtype=="input"){
								e+=printXtype.input(row,size_label,size_input);
							}else if(row.xtype=="fieldset"){
								e+=printXtype.fielset(row,size_label,size_input);
							}else if(row.xtype=="html"){
								e+=printXtype.html(row);
							}
						}
					
					});

				}
  				e+='</fieldset>';
  				return e;
		},
		input:function(data,size_label,size_input){	
			var d=$.extend({
					xtype:'input',
					type:'text',
					value:'',
					required:true,
					pattern:'',
					disabled:false,
					title:'',
					clas:'',
					name:'',
					label:'',
					inline:true, // muestra los radio y los chk en un amisma linea
					help:'',
					textarea_row:3,
					attr:{}
				},data);


				size_label=$.extend({
					xs:12,sm:3,md:3,lg:3
				},size_label);

				size_input=$.extend({
					xs:12,sm:9,md:9,lg:9
				},size_input);



				/*
					// items para radio y check box
				items [
						{
							label:'',
							value:'',
							select:false
						},{
							label:'',
							value:'',
							select:false
						}
					]

				*/





			////console.log(d);
			var txtdisable=(d.disabled)? "disabled":"";
			var labeldisable="labeldisabledjj";

			var id=jj.getId();
			var e='';
			if(d.type=='hidden'){ // hidden solo crea el input, y no los campos adicionales para el responsive

				e = '<input type="hidden" id="inputjsongenjj'+id+'" name="'+d.name+'"  value="'+d.value+'"  >';
			
			}else if(d.type=='textarea'){

				e = '<div class="form-group">'+
				   		'<label for="inputjsongenjj'+id+'" class=" col-xs-'+size_label.xs+' col-sm-'+size_label.sm+' col-md-'+size_label.md+' col-lg-'+size_label.lg+'  control-label">'+d.label+'</label>'+
				   		'<div class=" col-xs-'+size_input.xs+' col-sm-'+size_input.sm+' col-md-'+size_input.md+' col-lg-'+size_input.lg+'  ">';
				     		
				     							// genera un input
				     			var requiredjj=(d.required)? "required": "";
								e+='<textarea  rows="'+d.textarea_row+'" id="inputjsongenjj'+id+'" name="'+d.name+'" '+txtdisable+'  class="form-control '+d.clas+'"  ';
				     			$.each(d.attr, function(index, row) { 
									e+=index+'="' + row + '" ';
								});
					     		e+=requiredjj+'  >'+d.value+'</textarea>';
				     		
				     		

				   		e+='<span class="help-block_errorjj help-block" style="display:none"></span>';
				   		if(d.help!=''){
				   			e+='<span class="help-block help-blockjj">'+d.help+'</span>';
				   		}
				   		e+='</div>'+
				   	'</div>';

			}else if(d.type=='select'){


					e = '<div class="form-group">'+
				   		'<label for="inputjsongenjj'+id+'" class=" col-xs-'+size_label.xs+' col-sm-'+size_label.sm+' col-md-'+size_label.md+' col-lg-'+size_label.lg+'  control-label">'+d.label+'</label>'+
				   		'<div class=" col-xs-'+size_input.xs+' col-sm-'+size_input.sm+' col-md-'+size_input.md+' col-lg-'+size_input.lg+'  ">';
				     		
				     						// genera un input
				     		//var requiredjj=(d.required)? "required": "";
							e+='<select id="inputjsongenjj'+id+'" name="'+d.name+'" '+txtdisable+'  class="form-control input-sm '+d.clas+'"  ';
				     		$.each(d.attr, function(index, row) { 
									e+=index+'="' + row + '" ';
							});
					     	//e+=requiredjj+'  >';
					     	e+='  >';


					     	$.each(d.items, function(ind, intp) { 
								var v=$.extend({
												label:'',
												value:''
												},intp);
								var vv_selected=(v.value==d.value)? "selected":"";
					     		e+='<option value="'+v.value+'" '+vv_selected+'>'+v.label+'</option>';

							});

							e+='</select>';
				     		
				     		

				   		e+='<span class="help-block_errorjj help-block" style="display:none"></span>';
				   		if(d.help!=''){
				   			e+='<span class="help-block help-blockjj">'+d.help+'</span>';
				   		}
				   		e+='</div>'+
					'</div>';



			}else if(d.type=='radio'||d.type=='checkbox'){


				e = '<div class="form-group">'+
				   		'<label class=" col-xs-'+size_label.xs+' col-sm-'+size_label.sm+' col-md-'+size_label.md+' col-lg-'+size_label.lg+'  control-label">'+d.label+'</label>'+
				   		'<div class=" col-xs-'+size_input.xs+' col-sm-'+size_input.sm+' col-md-'+size_input.md+' col-lg-'+size_input.lg+'  ">';
				     			

									$.each(d.items, function(ind, intp) { 

										var v=$.extend({
												label:'',
												value:'',
												name:'',
												checked:false,
												required:'',
												disabled:false
												},intp);
										var v_name=(v.name=='')? d.name:v.name;
										var v_checked=(v.checked)? 'checked':'';
										var v_required=(typeof v.required == "string")? (d.required)? 'required':'' :(v.required)? 'required':'';

										txtdisable=(d.disabled)? "disabled":(v.disabled)? "disabled":"";

										labeldisable=(txtdisable=="")? "":"labeldisabledjj";

										if(d.inline){
											e+='<label class="'+d.type+'-inline">';
										}else{
											e+='<div class="'+d.type+'">'+
											'<label>';
										}

										e+='<input type="'+d.type+'" name="'+ v_name +'" value="'+v.value+'" '+txtdisable+' class="'+d.clas+'" '+v_checked+' '+v_required+' ';
				     					$.each(d.attr, function(index, row) { 
											e+=index+'="' + row + '" ';
										});
					     				e+='  ><span class="'+labeldisable+'">'+ v.label+'</span>' ;
					     				
					     				e+='</label>';
					     				if(!d.inline){
											e+='</div>';
										}


									});
					     			

				   		e+='<span class="help-block_errorjj help-block" style="display:none"></span>';
				   		if(d.help!=''){
				   			e+='<span class="help-block help-blockjj">'+d.help+'</span>';
				   		}
				   		e+='</div>'+
					'</div>';

			}else if(d.type=='checkbtn'){


				e = '<div class="form-group">'+
				   		'<label class=" col-xs-'+size_label.xs+' col-sm-'+size_label.sm+' col-md-'+size_label.md+' col-lg-'+size_label.lg+'  control-label">'+d.label+'</label>'+
				   		'<div class=" col-xs-'+size_input.xs+' col-sm-'+size_input.sm+' col-md-'+size_input.md+' col-lg-'+size_input.lg+'  ">';
				     			

									$.each(d.items, function(ind, intp) { 

										if(d.inline){
											e+='<label class="'+d.type+'-inline checkboximgjj">';
										}else{
											e+='<div class="'+d.type+'">'+
											'<label class="checkboximgjj">';
										}
										

										var v=$.extend({
												label:'',
												value:'',
												name:'',
												checked:false,
												required:''
												},intp);
										var v_name=(v.name=='')? d.name:v.name;
										var v_checked=(v.checked)? 'checked':'';
										var v_required=(typeof v.required == "string")? (d.required)? 'required':'' :(v.required)? 'required':'';
										txtdisable=(d.disabled)? "disabled":(v.disabled)? "disabled":"";
										labeldisable=(txtdisable=="")? "":"labeldisabledjj";
										e+=' <input type="checkbox" name="'+ v_name +'" value="'+v.value+'" '+txtdisable+' class="'+d.clas+'" '+v_checked+' '+v_required+' ';
				     					$.each(d.attr, function(index, row) { 
											e+=index+'="' + row + '" ';
										});
					     				e+='><div class="btnonoffjj"><div></div></div><span class="'+labeldisable+'">'+ v.label+'</span>' 
					     				
					     				e+='</label>';
					     				if(!d.inline){
											e+='</div>';
										}


									});
					     			

				   		e+='<span class="help-block_errorjj help-block" style="display:none"></span>';
				   		if(d.help!=''){
				   			e+='<span class="help-block help-blockjj">'+d.help+'</span>';
				   		}
				   		e+='</div>'+
					'</div>';

			}else{

				e = '<div class="form-group">'+
				   		'<label for="inputjsongenjj'+id+'" class=" col-xs-'+size_label.xs+' col-sm-'+size_label.sm+' col-md-'+size_label.md+' col-lg-'+size_label.lg+'  control-label">'+d.label+'</label>'+
				   		'<div class=" col-xs-'+size_input.xs+' col-sm-'+size_input.sm+' col-md-'+size_input.md+' col-lg-'+size_input.lg+'  ">';
				     		
				     		if(d.type=='static'){ // genera un input estatic

				     			e+='  <p class="form-control-static '+d.clas+'">'+d.value+'</p> ';

				     		}else{				// genera un input

				     			var requiredjj=(d.required)? "required": "";
				     			var patternjj=(d.pattern=='')? '':'pattern="'+d.pattern+'"';

								e+='<input type="'+d.type+'" id="inputjsongenjj'+id+'" name="'+d.name+'" value="'+d.value+'" title="'+d.title+'" '+txtdisable+' class="form-control input-sm '+d.clas+'"  ';
				     			$.each(d.attr, function(index, row) { 
									e+=index+'="' + row + '" ';
								});
					     		e+=' '+patternjj+' '+requiredjj+'  >';
				     		}
				     		

				   		e+='<span class="help-block_errorjj help-block" style="display:none"></span>';
				   		if(d.help!=''){
				   			e+='<span class="help-block help-blockjj">'+d.help+'</span>';
				   		}
				   		e+='</div>'+
					'</div>';	
			}
			
			return e;
		},
		html:function(data){	
			
				 ////console.log(data);

			var d=$.extend({
				xtype:'html',
				msg:''
			},data);
  				return d.msg;



		}
	};


	var c_jj={
		form:function(data){

  				
  				var d=$.extend({
						action:'',
						clas:'',
						size_label:{xs:12,sm:3,md:3,lg:2},
						size_input:{xs:12,sm:9,md:9,lg:10}
				},data);

				

				var form='<form action="'+d.action+'"  class="frmgeneradotoolsjj form-horizontal '+ d.clas +' " role="form">';

				$.each(d.items, function(index, row) { 
					////console.log(row.xtype);
					if(typeof row.xtype!="undefined"){
						if(row.xtype=="input"){
							form+=printXtype.input(row,d.size_label,d.size_input);
						}else if(row.xtype=="fieldset"){
							form+=printXtype.fieldset(row,d.size_label,d.size_input);
						}else if(row.xtype=="html"){
							form+=printXtype.html(row);
						}
					}
					
				});
 			

				form+='<input type="submit" value="enviar" style="display:none" ></form>';

				return form;
  		}


	};
	jj.build=function(type,data){
		if ( c_jj[type] ) {
      		return c_jj[type].apply( this, Array.prototype.slice.call( arguments, 1 ));
    	} else {
      		$.error( 'El metodo ' +  type + ' no existe' );
    	}    
	};	
	
})( jQuery );



// msg
(function( $ ){

	var c_jj={
		ini:function(type,cont,time){
			
			var divvacio=this.getdivvacio();
			divvacio.addClass('alert alert-'+type);
			divvacio.css('margin-bottom',0);
			divvacio.html('<button type="button" class="close">×</button>'+cont);
			divvacio.find('button.close').on('click',function(){
				divvacio.fadeOut('slow', function() {
					 divvacio.remove();
				});
			});
			if(typeof time =='number'){
				if(time>0){
					setTimeout(function(){
						divvacio.fadeOut('slow', function() {
						    divvacio.remove();
						});
					},(time*1000));
				}
			}
			return divvacio;
		},
		loading:function(cont,time){
			

			var divvacio=this.getdivvacio();
			divvacio.addClass('alert alert-info');
			divvacio.css('margin-bottom',0);
			divvacio.html('<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="20"><i class="fa fa-spinner fa-spin"></i></td><td>'+cont+'</td><td width="1"><button type="button" class="close">×</button></td></tr></table>');
			divvacio.find('button.close').on('click',function(){
				divvacio.fadeOut('slow', function() {
					 divvacio.remove();
				});
			});
			if(typeof time =='number'){
				if(time>0){
					setTimeout(function(){
						divvacio.fadeOut('slow', function() {
						    divvacio.remove();
						});
					},(time*1000));
				}
			}
			return divvacio;
		},
		getdivvacio:function(){
			var divcont=$('#jsdfnksdfasydbfaljkfvbhaduyvbfdaf');
			if(divcont.length==0){
				$('body').append('<div id="jsdfnksdfasydbfaljkfvbhaduyvbfdaf"></div>');
				divcont=$('#jsdfnksdfasydbfaljkfvbhaduyvbfdaf');
				divcont.css({
					'position' : 'fixed',
					'right'    : '2px',
					'width'    : '320px',
					'top'      : '50px',
					'z-index'  : '1240'
					});
			}
			var divvacio=divcont.find('div:empty:first');
			if(divvacio.length==0){
				divcont.append('<div></div>'); 
				divvacio=divcont.find('div:empty:first');
			}
			return divvacio;
		}

	}

	jj.msg = function( txt,time  ) {
  			if(typeof txt=='undefined'){return false;}
			var t=(typeof time=='undefined')? 3 : time;
			return c_jj.ini('info',txt,t);
	};

	jj.msg.success = function( txt,time ) {
  			if(typeof txt=='undefined'){return false;}
			var t=(typeof time=='undefined')? 3 : time;
			return c_jj.ini('success',txt,t);
	};

	jj.msg.info = function( txt,time ) {
  			if(typeof txt=='undefined'){return false;}
			var t=(typeof time=='undefined')? 3 : time;
			return c_jj.ini('info',txt,t);
	};

	jj.msg.warning = function( txt,time ) {
  			if(typeof txt=='undefined'){return false;}
			var t=(typeof time=='undefined')? 3 : time;
			return c_jj.ini('warning',txt,t);
	};

	jj.msg.danger = function( txt,time ) {
  			if(typeof txt=='undefined'){return false;}
			var t=(typeof time=='undefined')? 3 : time;
			return c_jj.ini('danger',txt,t);
	};
	jj.msg.loading=function(txt,time){
			if(typeof txt=='undefined'){return false;}
			var t=(typeof time=='undefined')? 3 : time;

			return c_jj.loading(txt,t);
	}
})( jQuery );



// ajax
(function( $ ){

	var c_jj={
		ini:function(op){
			
			var p={
					url:'',
					dataAjax: {},
					divBlock:'',
					cb:function(){},
					dataType:'html',
					closeMsgEnd:true
				};
			
			p=$.extend(p,op);
			
			if(typeof p.divBlock=="string"){
				if(p.divBlock!=''){
					p.divBlock=$(p.divBlock);
				}
			}

			if(typeof p.divBlock == "object"){
				p.divBlock.divblockjj();
			}

			var msgAjax;

			$.ajax({
			        url: p.url,
			        type: "POST",
			        data:p.dataAjax,
			        dataType: p.dataType,
			        beforeSend: function(objeto){
			            msgAjax=jj.msg.loading('Cargando',0); 
			        },
			        success: function(datos){
			            if(p.closeMsgEnd){
							msgAjax.find('button.close').trigger('click');
						}
						p.cb(datos);
			        },
			        error: function(objeto, quepaso, otroobj){
			        	msgAjax.find('button.close').trigger('click');
			            jj.msg.danger('Error en el servidor, '+quepaso,0);
			        },
			        complete: function(objeto, exito){
			            //if(exito=="success"){}
						if(typeof p.divBlock == "object"){
							p.divBlock.divblockjj('destroy'); 
						}
			        }
			});

		}
	}

	jj.ajax = function( op ) {
  		c_jj.ini(op);
	};
	jj.ajax.load = function( op ) {
  			var p={
					url:'',
					dataAjax: {},
					divAjax:'',
					divBlock:'',
					cb:function(){},
					dataType:'html',
					closeMsgEnd:true
				};
			
			p=$.extend(p,op);
			if(typeof p.divAjax=="string"){
				if(p.divAjax==''){
					jj.msg.danger('Error Seleccionar un Contenedor para el AJAX',0);
					return false;
				}else{
					p.divAjax=$(p.divAjax);
				}
			}
			if(typeof p.divAjax != "object"){
					jj.msg.danger('Error Seleccionar un Contenedor  para el AJAX',0);
					return false;
			}
			c_jj.ini({
					url:p.url,
					dataAjax: p.dataAjax,
					divBlock:p.divBlock,
					cb:function(data){
						p.divAjax.html(data);
						p.cb(data);		
					},
					dataType:p.dataType,
					closeMsgEnd:p.closeMsgEnd
			});
	};


	jj.ajax.dialog = function( op ) {
  			var p={
					url:'',
					dataAjax: {},
					title:'',
					load:function(){},
					close:function(){}
				};
			
			p=$.extend(p,op);
			
			c_jj.ini({
					url:p.url,
					dataAjax: p.dataAjax,
					cb:function(data){
						
						jj.box({
							msg:data,						
							title:p.title,					
							foot:true,						
							foot_close:true,				
							foot_close_txt:'Cerrar',		
							foot_close_color:'btn-default',	
							foot_focus:'Cerrar',			
							close:p.close,					
							load:p.load						
						});

					}
			});




			








	};

})( jQuery );



// box
(function( $ ){
  		
  		var c_jj={
			templates : {
    			dialog:
    			 	'<div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
					  '<button type="button" style="display:none;" class="closejj_box" data-dismiss="modal" ></button>' +
					  '<div class="modal-dialog">' +
					    '<div class="modal-content">' +
					      '<div class="modal-body"></div>' +
					    '</div>' +
					  '</div>' +
					'</div>',
    			head:
    			    '<div class="modal-header">' +
    			    	'<h4 class="modal-title" ></h4>' +
    			    '</div>',
    			foot:
    			    '<div class="modal-footer"></div>',
    			closeButtonHead:
    			    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>',
    			closeButtonFoot:
    				'<button type="button" class="btn" data-dismiss="modal"></button>',
    			buttonFoot:
    				'<button type="button" class="btn btn-primary">Save changes</button>'	
  			},
  			build_buton_foot:function(c,l){
  				return '<button type="button" class="btn '+c+'">'+l+'</button>';
  			},
  			dialog:function(op){
  				var p={
					msg:'',									//contenido del modal
					head:true,								// mostrar titulo del modal
					head_close:true,						// add boton de cerrar en el titulo
					title:'',								// titulo del modal
					foot:false,								// botones en el foot del modal
					foot_close:true,						// add boton de cerrar al modal
					foot_close_txt:'Cerrar',				// texto del boton cerrar
					foot_close_color:'btn-default',			// color del boton cerrar
					foot_focus:'Cerrar',					// foco del boton al crearse el modal
					buttons:'',								// lista de botones a agregar al foot del modal	
					close:function(){},						// evento cuando se cierra el modal
					load:function(){}						// evento cuando se abre el modal
				};
				p=$.extend(p,op);
				var thisjj=this;
				var d=$(thisjj.templates.dialog);
				if(p.head){												// para crear  el title 
					var d_h=$(thisjj.templates.head);					// instancio el head modal
					d_h.find('h4').html(p.title);						
					if(p.head_close){									// si se pone el boton de cerrar
						d_h.prepend(thisjj.templates.closeButtonHead);
					}
					d.find('.modal-content').prepend(d_h);
				}
				if(p.foot){												// para crear el foot de botones
					var d_f=$(thisjj.templates.foot);
					if(p.foot_close){
						var d_f_c=$(thisjj.templates.closeButtonFoot);
							d_f_c.addClass(p.foot_close_color);
							d_f_c.html(p.foot_close_txt);
						d_f.prepend(d_f_c);

					}
					
					if(typeof p.buttons == 'object'){
						var btn_d_f;
						$.each( p.buttons, function( k, dv ) {
  							btn_d_f=$(thisjj.build_buton_foot(dv.className,dv.label));
  							if(typeof dv.callback == 'function'){
  								btn_d_f.on('click',{dlgjj:d},dv.callback);
  							}
  							d_f.append(btn_d_f);
						});
					}
					d.find('.modal-content').append(d_f);
				}

				d.find('.modal-body').html(p.msg);

				d.on("box.close.jj", function(e) {
      				d.find('.closejj_box').trigger('click');
    			});


				

    			d.on("shown.bs.modal",function(){
    				if(p.foot){
						d.find('div.modal-footer').find("button.btn:contains('"+p.foot_focus+"')").focus();
					}
					if(typeof p.load=="function"){
						p.load(d);
					}

    			});
				//d.on("show.bs.modal",  );
    			d.on("hide.bs.modal",{dlgjj:d},p.close );
    			d.on("hidden.bs.modal", function(){
    				d.remove();
    			});

				d.modal({backdrop:'static'});

				return d;

  			}
  			
  		};

  		jj.box = function( op ) {
  			c_jj.dialog(op);
  		};

    	jj.box.alert = function(txt,cb){
   		
   			c_jj.dialog({
   				msg:txt,
				head:false,
				foot:true,
				foot_close:true,
				foot_close_txt:'OK',
				foot_close_color:'btn-primary',
				foot_focus:'OK',
				close:(typeof cb == 'function')? cb:function(){}
   			});

   		}

   		jj.box.confirm =function(txt,cb){
	
   			c_jj.dialog({
   				msg:txt,
				head:false,
				foot:true,
				foot_close:false,
				load:function(e){
					e.data('rpta',false);
				},
				close:function(e){
					if(typeof cb =='function'){
						cb(e.data.dlgjj.data('rpta'));
					}
				},
				foot_focus:'Cancelar',
				buttons: {
  					ok: {
  					  label: "OK",
  					  className: "btn-primary",
  					  callback: function(e) {
  					  		e.data.dlgjj.data('rpta',true);
  					  		e.data.dlgjj.trigger("box.close.jj");
  					  }
  					},
  					cancel: {
  					  label: "Cancelar",
  					  className: "btn-default",
  					  callback: function(e) {
  					    	e.data.dlgjj.trigger("box.close.jj");
  					  }
  					}
  				}
   			});
    	}


    	jj.box.prompt =function(txt,cb){
	
   			c_jj.dialog({
   				msg:'<input type="text" class="form-control txt_jj_box_prompt" placeholder="">',
				head:true,
				title:txt,
				foot:true,
				foot_close:false,
				load:function(e){
					e.data('rpta',null);
					//console.log(e.data('rpta'));
				},
				close:function(e){
					if(typeof cb =='function'){
						cb(e.data.dlgjj.data('rpta'));
					}
				},
				foot_focus:'Cancelar',
				buttons: {
  					ok: {
  					  label: "OK",
  					  className: "btn-primary",
  					  callback: function(e) {
  					  	var value= e.data.dlgjj.find('.txt_jj_box_prompt').val();
  					  		e.data.dlgjj.data('rpta',value);
  					  		e.data.dlgjj.trigger("box.close.jj");
  					  }
  					},
  					cancel: {
  					  label: "Cancelar",
  					  className: "btn-default",
  					  callback: function(e) {
  					    	e.data.dlgjj.trigger("box.close.jj");
  					  }
  					}
  				}
   			});
    	}

    	jj.box.form =function(op){

    		var p={
    				build_form:'', // si es string indicar la ruta por ajax donde se va a obtener el json de cracion del formulario
    				dataAjax:{},// en caso de usar el formulario por ajax se envian estos datos
    				title:'',
					head:true,
					head_close:true,
					foot:true,
					foot_close:true,
					foot_close_txt:'Cancelar',
					foot_close_color:'btn-default',
					foot_focus:'Cancelar',
					from_success:function(){},
					buttons: {
  						save: {
  						  label: "Guardar",
  						  className: "btn-primary",
  						  callback: function(e) {
  						  	var frmjj=e.data.dlgjj.find('.frmgeneradotoolsjj').first();
  						  	frmjj.find('input:submit').trigger("click");
  						  }
  						}
  					},
					load:function(e){
						////console.log('iniciado');
						e.data('frm_data',null);
						var frmjj=e.find('.frmgeneradotoolsjj').first();
						frmjj.on('submit',function(event){
  						  		event.preventDefault();
  						  		var frm=$(this);

  						  		
  						  		jj.ajax({
									url:frm.attr('action'),
									dataAjax:frm.serializeArray(),
									divBlock:e.find('div.modal-footer'),
									cb:function(data){
										
										if(data.est){
											if(data.showmsg){
												jj.msg.success(data.msg,10);
											}
											e.prev('.modal-backdrop').remove();
  						  					e.remove();
  						  					p.from_success();
										}else{
											if(data.msg!=""){
												jj.msg.danger(data.msg,0);
											}
											var frm_group;
											var frm_div=frmjj.find('div.form-group');
											frm_div.removeClass('has-error');
											frm_div.find('span.help-block_errorjj').html('').hide();

											$.each( data.txt_error, function( key, value ) {
  												frm_group=frmjj.find("div.form-group:has([name='"+key+"'])");
  												frm_group.addClass('has-error');
  												frm_group.find('span.help-block_errorjj').html(value).show();
											});
										}
									},
									dataType:'json'
  						  		}); 		

  						});
					},
					close:function(e){
						e.parents("div.modal_creado_toolsjj2").find(".closejj_box").trigger("click")
					}
				};
			p=$.extend(p,op);
			if(p.title==""){
				p.head=false;
			}
			if(typeof p.build_form=="string"){
				if(p.build_form==''){return false;}
				jj.ajax({
					url:p.build_form,
					dataAjax:p.dataAjax,
					cb:function(data){
						p.build_form=data;
						p.msg=jj.build('form',p.build_form);
						c_jj.dialog(p);
					},
					dataType:'json'
				});
			}else{
				p.msg=jj.build('form',p.build_form);
				c_jj.dialog(p);
			}
    	}

})( jQuery );
