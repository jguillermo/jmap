<html>
<head>
<title>Consulta RUC</title>

<link href="/a/css/estilos2_0.css" rel="stylesheet" type="text/css">
</head>
<script language="JavaScript" src="/a/js/js.js"></script>
<link href="/a/css/estilos2_0.css" rel="stylesheet">
<script languaje="JavaScript" type="text/javascript">
function validaemail(F) {
var estrep=document.getElementById("div_estrep");
var progress=document.getElementById("div_progress");
	email = F.email.value;
	var ok = validacorreo(email);
	if (!ok) {
		alert("Email no válido");
		return false
	}
	F.correo.value = email.value;
	//estrep.style.display="none";
	//progress.style.display="block";
	//window.setInterval("avance()",20);
	return true;
}
	
function submitLocAnex(){
var estrep=document.getElementById("div_estrep");
var progress=document.getElementById("div_progress");
//document.formLocAnex.submit();
estrep.style.display="none";
progress.style.display="block";
window.setInterval("avance()",20);
}
/*
SWF-[PAS20145E210000234]:R_DSNT_0060_informacion_consulta_ruc    
*/  
function submitIGVImpuesto(){
var estrep=document.getElementById("div_estrep");
var progress=document.getElementById("div_progress");
//document.formLocAnex.submit();
estrep.style.display="none";
progress.style.display="block";
window.setInterval("avance()",20);
}


function submitRetencion(){
var estrep=document.getElementById("div_estrep");
var progress=document.getElementById("div_progress");
//document.formLocAnex.submit();
estrep.style.display="none";
progress.style.display="block";
window.setInterval("avance()",20);
}

function submitRentaSalReg(){
var estrep=document.getElementById("div_estrep");
var progress=document.getElementById("div_progress");
//document.formLocAnex.submit();
estrep.style.display="none";
progress.style.display="block";
window.setInterval("avance()",20);
}


/*
SWF-[PAS20145E210000234]:R_DSNT_0060_informacion_consulta_ruc    
*/

function submitRepLeg(){
var estrep=document.getElementById("div_estrep");
var progress=document.getElementById("div_progress");
//document.formRepLeg.submit();
estrep.style.display="none";
progress.style.display="block";
window.setInterval("avance()",20);
}

function submitActPro(){
var estrep=document.getElementById("div_estrep");
var progress=document.getElementById("div_progress");
//document.formRepLeg.submit();
estrep.style.display="none";
progress.style.display="block";
window.setInterval("avance()",20);
}

function submitInforHist(){
var estrep=document.getElementById("div_estrep");
var progress=document.getElementById("div_progress");
//document.forminfoHist.submit();
estrep.style.display="none";
progress.style.display="block";
window.setInterval("avance()",20);
}
function cargar(){
document.formEnviar.pagina.value="datosRuc";
document.formEnviar.email.value="";
}
function Imprimible(){
 var print = window.open("", "versionImprimible");
 var valor = document.getElementById("print").innerHTML;
print.document.write("<html><title>Consulta RUC: versi&oacute;n Imprimible</title><link href='../../../a/css/estilos2_0.css' rel='stylesheet' type='text/css'><body >" + valor + "<br><br><input class=form-button type='button' name='imprimir' value='Imprimir' onclick='window.print();'></body></html>");
 print.document.close();
}

function validaFrameNulo(){
   if(window.parent.leftFrame != null){
   		window.parent.leftFrame.goRefresh();
   }
   /*window.parent.resetContPag(); */
   cargar();
}
</script>



<body onload="JavaScript:validaFrameNulo(); ">
<table border="0" cellpadding="2" cellspacing="3" width="100%" class="form-table">
          <tr>            	  
            <td width="18%" colspan=1  class="bgn">N&uacute;mero de RUC: </td>
            <td  class="bg" colspan=3>20483500620 - CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL</td>
          </tr>
          <tr>
            <td class="bgn" colspan=1>Tipo Contribuyente: </td>
            <td class="bg" colspan=3>EMPRESA INDIVIDUAL DE RESP. LTDA</td>
          </tr>
          
            <tr>
              <td class="bgn" colspan=1 >Nombre Comercial: </td>
              <td class="bg" colspan=1>-</td>
              
            </tr>
            <tr>
              <td class="bgn" colspan=1>Fecha de Inscripci&oacute;n: </td>
              <td class="bg" colspan=1>02/12/2015</td>
              <td width="27%" colspan=1 class="bgn">Fecha de Inicio de Actividades:</td>
              <td class="bg" colspan=1> 02/12/2015</td>
            </tr>
            <tr>
              <td class="bgn" colspan=1>Estado del Contribuyente: </td>
              <td class="bg" colspan=1>ACTIVO</td>
              <td class="bgn" colspan=1>
              
                </td>
                
            </tr>
            <tr>
              <td class="bgn"colspan=1>Condici&oacute;n del Contribuyente:</td>
              <td class="bg" colspan=3>
              
              HABIDO
              
              </td>        
            </tr>   
            <tr>
              <td class="bgn" colspan=1>Direcci&oacute;n del Domicilio Fiscal:</td>
              <td class="bg" colspan=3>CAL.BOLOGNESI NRO. 421 TUMBES                                                                                                                             - CONTRALMIRANTE VILLAR                                                                                                              - ZORRITOS</td>
            </tr>
<!--     SE COMENTO POR INDICACION DEL PASE PAS20134EA20000207  -->
<!--            <tr>  -->
<!--              <td class="bgn" colspan=1>Tel&eacute;fono(s):</td>  -->
<!--              <td class="bg" colspan=1>/ 957697801 </td> -->
<!--              <td class="bgn" colspan=1>Fax:</td> -->
<!--              <td class="bg" colspan=1> -->
<!--               -->	
<!--                -  -->
<!--                -->
<!--              </td>	  -->
<!--             </tr>  -->

             <tr>
               <td class="bgn" colspan=1>Sistema de Emisi&oacute;n de Comprobante:</td>
               <td class="bg" colspan=1>MANUAL</td>
               <td class="bgn" colspan=1>Actividad de Comercio Exterior:</td>
               <td class="bg" colspan=1>SIN ACTIVIDAD</td>
             </tr>
             <tr>
               <td class="bgn" colspan=1>Sistema de Contabilidad:</td>
               <td class="bg" colspan=1>MANUAL</td>
               	    	
             </tr>
             
          <tr>
          	<!--I#P_SNADE003-1#20141109#CFS-->
            <!--<td class="bgn" colspan=1>Actividad(es) Econ&oacute;mica(s):</td>-->
            <td class="bgn" colspan=1>Actividad(es) Econ&oacute;mica(s):</td>
            <!--F#P_SNADE003-1#20141109#CFS-->
            <td class="bg" colspan=3>
              <!--I#P_SNADE003-1#20141109#CFS-->
              <!-- <select name="select" >-->
              <!--   -->
              <!--   <option value="00" > Principal        - CIIU 45207 - CONSTRUCCION EDIFICIOS COMPLETOS. </option>-->
              <!--   -->
              <!--   -->
              <!--   -->
              <!--   -->
            	<!-- </select>	-->	
              <select name="select" >
                
                <option value="00" > 4100 - CONSTRUCCIÓN DE EDIFICIOS </option>
                <!--SC003-2015 Inicio-->
                
                <!--SC003-2015 Fin-->
                
                <!--SC003-2015 Fin-->
                
                
                <!--SC003-2015 Fin-->
                
                <!--SC003-2015 Inicio-->
				
				
            </select>		
            	<!--F#P_SNADE003-1#20141109#CFS-->
		   </td>
          </tr>
          <tr>
            <td class="bgn" colspan=1>Comprobantes de Pago c/aut. de impresión (F. 806 u 816): </td>
            <td class="bg" colspan=3>
              <select name="select">
                
                
                
                
                
                <option value="00" > FACTURA</option>
                
                
                <option value="00" > NOTA DE CREDITO</option>
                
                
                <option value="00" > GUIA DE REMISION - REMITENTE</option>
                
                
            </select>
            </td>  	  
          </tr>
          <!--  PCR Inicio Cambios  -->
          <tr>
            <td class="bgn" colspan=1>Sistema de Emision Electronica: </td>
            <td class="bg" colspan=3>
              
                
                 -
                
                
            </td>  
          </tr>
          <!--  MLR Inicio Cambios P_DSNT_CPLE_0009_5_FE-MASIFICACION-->
          <tr>
            <td class="bgn" colspan=1>Emisor electr&oacute;nico desde: </td>
            <td class="bg" colspan=3>-</td>
          </tr>
          <tr>
            <td class="bgn" colspan=1>Comprobantes Electr&oacute;nicos: </td> 
            <td class="bg" colspan=3>-</td>
          </tr>
          <!--  MLR Fin Cambios P_DSNT_CPLE_0009_5_FE-MASIFICACION-->    
          
          <tr>
            <td class="bgn" colspan=1>Afiliado al PLE desde: </td>
            <td class="bg" colspan=3>- </td>
	  
          </tr>
          <!--  PCR Fin Cambios     -->
          <tr>
            <td class="bgn" colspan=1>Padrones :</td>
            <td class="bg" colspan=3>
              <select name="select"  >
		
	                       
                
                
                

				<!-- JRR - 20/09/2010 - Se añade cambio de Igor -->
				
                
                
                
				<!--  -->
                
		<option value="00" >NINGUNO</option>
                
            </select>
            <div id="print" style="display:none;">
            	<table cellpadding="3" cellspacing="2" width="100%" class="form-table">
	<tr>
  		<td class="t1"><font size="2">CONSULTA RUC: 20483500620 - CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL</font></td>
	</tr>
	</table>
            	<table border="0" cellpadding="2" cellspacing="3" width="100%" class="form-table">
	          <tr>            	  
	            <td width="18%" colspan=1  class="bgn">N&uacute;mero de RUC: </td>
	            <td  class="bg" colspan=3>20483500620 - CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL</td>
	          </tr>
	          <tr>
	            <td class="bgn" colspan=1>Tipo Contribuyente: </td>
	            <td class="bg" colspan=3>EMPRESA INDIVIDUAL DE RESP. LTDA</td>
	          </tr>
	          
	            <tr>
	              <td class="bgn" colspan=1 >Nombre Comercial: </td>
	              <td class="bg" colspan=1>-</td>
	              
	            </tr>
	            <tr>
	              <td class="bgn" colspan=1>Fecha de Inscripci&oacute;n: </td>
	              <td class="bg" colspan=1>02/12/2015</td>
	              <td width="27%" colspan=1 class="bgn">Fecha Inicio de Actividades:</td>
	              <td class="bg" colspan=1> 02/12/2015</td>
	            </tr>
	            <tr>
	              <td class="bgn" colspan=1>Estado del Contribuyente: </td>
	              <td class="bg" colspan=1>ACTIVO</td>
	              <td class="bgn" colspan=1>
	              
	                </td>
	                
	            </tr>
	            <tr>
	              <td class="bgn"colspan=1>Condici&oacute;n del Contribuyente:</td>
	              <td class="bg" colspan=3>
	              
	              HABIDO
	              
	              </td>        
	            </tr>   
	            <tr>
	              <td class="bgn" colspan=1>Direcci&oacute;n del Domicilio Fiscal:</td>
	              <td class="bg" colspan=3>CAL.BOLOGNESI NRO. 421 TUMBES                                                                                                                             - CONTRALMIRANTE VILLAR                                                                                                              - ZORRITOS</td>
	            </tr>
<!--     SE COMENTO POR INDICACION DEL PASE PAS20134EA20000207  -->	            
<!--	            <tr>  -->
<!--	              <td class="bgn" colspan=1>Tel&eacute;fono(s):</td>  -->
<!--	              <td class="bg" colspan=1>/ 957697801 </td>  -->
<!--	              <td class="bgn" colspan=1>Fax:</td>  -->
<!--	              <td class="bg" colspan=1>  -->
<!--	                -->	
<!--	                -  -->
<!--	                -->
<!--	              </td>	  -->
<!--	             </tr>  -->
	             <tr>
	               <td class="bgn" colspan=1>Sistema de Emisi&oacute;n de Comprobante:</td>
	               <td class="bg" colspan=1>MANUAL</td>
	               <td class="bgn" colspan=1>Actividad de Comercio Exterior:</td>
	               <td class="bg" colspan=1>SIN ACTIVIDAD</td>
	             </tr>
	             <tr>
	               <td class="bgn" colspan=1>Sistema de Contabilidad:</td>
	               <td class="bg" colspan=1>MANUAL</td>
	               	    	
	             </tr>
	             
	          <tr>
	            <td class="bgn" colspan=1>Actividad(es) Econ&oacute;mica(s):</td>
	            <td class="bg" colspan=3>











						
		                Principal    - 4100 - CONSTRUCCIÓN DE EDIFICIOS<br>
		                <!--SC003-2015 Inicio-->
		                
		                <!--SC003-2015 Fin-->
		                
		                <!--SC003-2015 Fin-->
		                
		                

	            </td>
	          </tr>
	          <tr>
	            <td class="bgn" colspan=1>Comprobantes de Pago c/aut. de impresión (F. 806 u 816): </td>
	            <td class="bg" colspan=3>           	                              
	                
	                
	                
			<br>
	                
	                 FACTURA
	                
			<br>
	                
	                 NOTA DE CREDITO
	                
			<br>
	                
	                 GUIA DE REMISION - REMITENTE
	                
	                
	            </td>
	          </tr>         
	         
	      	  <!--ICR Inicio Cambios 23/11/2010 -->
          	  <tr>
                <td class="bgn" colspan=1>Sistema de Emisi&oacute;n Electr&oacute;nica: </td>
                <td class="bg" colspan=3>         
                   -                
                  
               </td>  
             </tr>
             <tr>
               <td class="bgn" colspan=1>Afiliado al PLE desde: </td>
               <td class="bg" colspan=3>- </td>	  
             </tr>
             <!--ICR Fin Cambios 23/11/2010 -->
	          
	          <tr>
	            <td class="bgn" colspan=1>Padrones :</td>
	            <td class="bg" colspan=3>
	                
	                
	                
	                
	                

					<!-- JRR - 20/09/2010 - Se añade cambio de Igor -->
	                
                	
                	
	                            
					<!--  -->

	                NINGUNO
	                		                              		              
	           </td>  	
	   </tr>      
	</table>
            <div>
	  </td>  	
   </tr>      
</table>
<span id="div_estrep" style="display:block;">
	<table border="0" cellpadding="2" cellspacing="2" width="100%" class="form-table">
	    <tr>
			<td align="center" valign="middle" colspan=1>
				<form name="forminfoHist" method="post" action="/cl-ti-itmrconsruc/jcrS00Alias">
				      <input name="submit" type="submit" class=form-button onClick="submitInforHist()" value="Informaci&oacute;n Hist&oacute;rica">          
				      <input type="hidden" name="accion" value="getinfHis">
				      <input type="hidden" name="nroRuc" value="20483500620">
				      <input type="hidden" name="desRuc" value="CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL">
				</form>
			</td>
			<td align="center" valign="middle" colspan=1>
				<form name="formInfoDeudaCoactiva" method="post" action="/cl-ti-itmrconsruc/jcrS00Alias">
				      <input name="submit" type="submit" class=form-button onClick="submitInforHist()" value="Deuda Coactiva">          
				      <input type="hidden" name="accion" value="getInfoDC">
				      <input type="hidden" name="nroRuc" value="20483500620">
				      <input type="hidden" name="desRuc" value="CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL">
				</form>
			</td>
			<td align="center" valign="middle" colspan=1>
				<form name="formInfoOmisionTributaria" method="post" action="/cl-ti-itmrconsruc/jcrS00Alias">
				      <input name="submit" type="submit" class=form-button onClick="submitInforHist()" value="Omisiones Tributarias">          
				      <input type="hidden" name="accion" value="getInfoOT">
				      <input type="hidden" name="nroRuc" value="20483500620">
				      <input type="hidden" name="desRuc" value="CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL">
				</form>
			</td>
  			<td align="center" valign="middle" colspan=1>
				<form name="formNumTrabajd" method="post" action="/cl-ti-itmrconsruc/jcrS00Alias">
				      <input name="submit" type="submit" class=form-button onClick="submitInforHist()" value="Cantidad de Trabajadores y/o Prestadores de Servicio">  
				      <input type="hidden" name="accion" value="getCantTrab">
				      <input type="hidden" name="nroRuc" value="20483500620">
				      <input type="hidden" name="desRuc" value="CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL">
				</form>
			</td>
	    </tr>
	
    <tr align="center" valign="middle" class="showScreen">    

      <td align="center" valign="middle" colspan=1>
          <form name="formActPro" method="post" action="/cl-ti-itmrconsruc/jcrS00Alias">
          <input class=form-button type="submit" onclick="submitActPro()" value="Actas Probatorias">
        <input type="hidden" name="accion" value="getActPro">
        <input type="hidden" name="desRuc" value="CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL">           
        <input type="hidden" name="nroRuc" value="20483500620">
        </form>
      </td>
<!--Ralvarado Ocultado a peticion de Galindes - Inicio--> 

<!--Ralvarado Ocultado a peticion de Galindes - Fin--> 
    </tr>

    <tr align="center" valign="middle" class="showScreen">    
      
      <td align="center" valign="middle" colspan=1>
        <form name="formRepLeg" method="post" action="/cl-ti-itmrconsruc/jcrS00Alias">
          <input class=form-button type="submit" onclick="submitRepLeg()" value="Representante(s) Legal(es)">
          <input type="hidden" name="accion" value="getRepLeg">
          <input type="hidden" name="desRuc" value="CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL">           
          <input type="hidden" name="nroRuc" value="20483500620">
        </form>
      </td>
      

      

    </tr>
    
    <tr>
      <td align="center" valign="middle" colspan=4>
        <div class="buttonbar">
          <html>
<head>

<script language="JavaScript" src="/a/js/js.js"></script>
<link href="/a/css/estilos2_0.css" rel="stylesheet">


</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" width="100%" >
	<tr align="center">
	    <td>
		
	    </td>
	    <td>
		<a href="#" onClick=" Imprimible();">
		<img src="/a/imagenes/impresora.gif" border="0" align="absmiddle">
		Version Imprimible
		</a>
	    </td>
	    <td valign="middle" class="bgn">
	    <br>
	        <form action="/cl-ti-itmrconsruc/jcrS00Alias" method="post" target="mainFrame" onSubmit="return validaemail(this)" name="formEnviar">
		        <!--inicio modificacion rmanriq1-->
		        <input type="hidden" name="nroRuc" value="20483500620">
                <input type="hidden" name="desRuc" value="CONSTRUCT.Y SERV.HERNAN PENA VINCES EIRL">
   		        <!--fin modificacion rmanriq1-->
				<input type="hidden" name="accion" value="enviar">	
				<input type="hidden" name="pagina" value="" >
				<input type="hidden" name="correo" value="">
				<img src="/a/imagenes/lgcorreo.gif" border="0" align="absmiddle"> &nbsp; e-mail <input type="text" name="email">
				<input type="submit" class="form-button" value="enviar">				
	      </form>
  	    </td>
</table>

</body>
</html>
 
        </div>
      </td>
    </tr>
  </table>
</span>
		
		
		
<table align="center" border="0" cellpadding="0" width="100%">
<tr>
<td>
<span id="div_progress" style="display:none;">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="/a/css/estilos2_0.css" rel="stylesheet">
<script languaje="JavaScript" type="text/javascript">

function activarAvance(){
    window.setInterval("avance()",20)
}

function avance(){
    lin1.style.pixelWidth=lin1.style.pixelWidth<700?lin1.style.pixelWidth + 2:0;
}
</script>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body onload="activarAvance()">
<table width="100%" height="100%"  border="0">
  <tr>
    <td valign="top">	
	<table width="100%"  border="0" align="center">
      <tr>
        <td><b class="warn">Por favor espere un momento...</b></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td valign="bottom">
	<table border="0" align="center">
      <tr>
		<td style="background-color:#B0C4DE;" id="lin1" width="0pt" height="18pt" ></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
</body>
</html>

</span>
</td>
</tr>
</table>
<html>
<head>
	<title>Footer</title>
</head>

<wl:cache name="JSPPieDePagina" timeout="1d">

<link href="/a/css/estilos2_0.css" rel="stylesheet">

<body>
<table width="100%" cellspacing="0" cellpadding="5" class="form-table">
<tr><td><!--
<div align="center">
<ADDRESS>
<p class="bg">Para sugerencias y consultas sobre el sitio web comun&iacute;quese con:<br>
<IMG height=32 src="/a/imagenes/lgcorreo.gif" width=32> <A href="mailto:Webmaster@sunat.gob.pe">Webmaster@sunat.gob.pe</A>
</p>
</ADDRESS>
</div>-->
<table width="100%" cellspacing="0" cellpadding="0">

<tr><th class="bgn">Copyright &copy; SUNAT 1997 - 2016</th></tr>
<tr>
<td width="100%" align="right"><a href="http://www.sunat.gob.pe/inicio.htm" target="_parent"><IMG alt=Inicio src="/a/imagenes/sunatpc.jpg" align=bottom border=0></a>
</td></tr></table>
</td></tr></table>

</body>
</wl:cache>
</html>    
</body>
</html>
