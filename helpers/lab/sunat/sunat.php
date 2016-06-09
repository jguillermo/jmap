<?php
var_dump($_POST);
?>
<html>
<head>
  <title>Consulta RUC</title>
</head>
  
  <script languaje="JavaScript" type="text/javascript">

function centraVentana(ancho,alto) {
  if (window.screen) {
    var aw = screen.availWidth;var ah = screen.availHeight;window.resizeTo(ancho,alto);window.moveTo((aw-ancho)/2,(ah-alto)/2);
  }
}
function algunCheck(form){
  for(i=0 ; i<form.elements.length; i++){
    if(form.elements[i].type == "checkbox"){if(form.elements[i].checked){return true;}}
  }
  return false;
}

  function diasEntreFechas(date1, date2){     
    if (date1.indexOf("-") != -1) { date1 = date1.split("-"); } else if (date1.indexOf("/") != -1) { date1 = date1.split("/"); } else { return 0; }     if (date2.indexOf("-") != -1) { date2 = date2.split("-"); } else if (date2.indexOf("/") != -1) { date2 = date2.split("/"); } else { return 0; }
    
    if (parseInt(date1[0], 10) >= 1000) {    
         
      var sDate = new Date(date1[0]+"/"+date1[1]+"/"+date1[2]);    
    } else if (parseInt(date1[2], 10) >= 1000) {
             
      var sDate = new Date(date1[2]+"/"+date1[1]+"/"+date1[0]);    
    } else {         
      return 0;     
    }     
    
    if (parseInt(date2[0], 10) >= 1000) {         
      var eDate = new Date(date2[0]+"/"+date2[1]+"/"+date2[2]);    
    } else if (parseInt(date2[2], 10) >= 1000) {         
      var eDate = new Date(date2[2]+"/"+date2[1]+"/"+date2[0]);    
    } else {         
      return 0;     
    }     
    
    var one_day = 1000*60*60*24;     
    
    var daysApart = Math.abs(Math.ceil((sDate.getTime()-eDate.getTime())/one_day));     
    
    return daysApart;  
  }

function esTeclaNumero(e) {
  var valid = "0123456789";
  var key = String.fromCharCode(event.keyCode);
    if (valid.indexOf("" + key) == "-1") return false;
}
function validarHora(strHora){
  if (longitudcorrecta(strHora, 5)) {
    strHora += ":00";
  }
  return !(!(/[0-2][0-9]:[0-5][0-9]:[0-5][0-9]/.test(strHora)) || (strHora.substring(0,2)<0 || strHora.substring(0,2)>23));
}
function formateafecha(valor){
  var l = StringTokenizer(valor, "/");
  return rellena(l[0], "0", 2) + "/" + rellena(l[1], "0", 2) + "/" + l[2];
}
function estelefono(valor){
  var pattern = "/\\b(^(\\d+)(\\-\\d+)$)\\b/gi";
  return valor.match(eval(pattern));
}
function esEntero(numero){
  tokens = StringTokenizer(numero, '.');
  return ( (tokens.length<=1)&&(esnumero(numero)) );
}
function validaDecimal(numero, dec){
  tokens = StringTokenizer(numero, '.');
  return (( tokens.length>1 )? (tokens[tokens.length-1].length > 0 && tokens[tokens.length-1].length <= dec) : true)&&(esdecimal(numero));
}
function esdecimal(valor){
  var pattern = "/\\b(^(\\d+)(\\.\\d+)$)\\b/gi";
  return valor.match(eval(pattern));
}
function validacorreo(myString) {
  return myString.match(/\b(^(\S+@).+((\.gob)|(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.biz)|(\.org)|(\..{2,}))$)\b/gi)
}
/* fn & ext Rt T F */
function validanombrearchivo(nombre, ext){
  var pattern = "/\\b(^(((\\S)|(\\s))+)(\\."+ext+")$)\\b/gi";
  return nombre.match(eval(pattern));
}
/* Rt Arr */
function StringTokenizer(cad, delim){
  var cads = new Array();
  var n = cad.length;
  var j = 0;
  var ic = 0;
  for (i=0;i<n;i++){
    if ( cad.charAt(i)==delim ){ cads[j] = cad.substring(ic, i); ic = i+1; j++; }
  }
  cads[j] = cad.substring(ic, n);
  return cads;
}
/*Rt m ltr: mes # / 1-12, may 1 o 0 M o m, cap 1 o 0 M 1ra lt*/
function mesenletras(mes, may, cap){
  if ( !esnumero(mes) ) return "-";
  var imes = parseInt(mes, 10);
  var tmes = "";
  if ( imes == 1 ) tmes = "enero";
  else if ( imes == 2 ) tmes = "febrero";
  else if ( imes == 3 ) tmes = "marzo";
  else if ( imes == 4 ) tmes = "abril";
  else if ( imes == 5 ) tmes = "mayo";
  else if ( imes == 6 ) tmes = "junio";
  else if ( imes == 7 ) tmes = "julio";
  else if ( imes == 8 ) tmes = "agosto";
  else if ( imes == 9 ) tmes = "setiembre";
  else if ( imes == 10 ) tmes = "octubre";
  else if ( imes == 11 ) tmes = "noviembre";
  else if ( imes == 12 ) tmes = "diciembre";
  if ( may == 1) tmes = tmes.toUpperCase(); 
  if ( cap == 1) tmes = tmes.substring(0,1).toUpperCase() + tmes.substring(1, tmes.length);
  return tmes;
}
/* -1: err, 1: f1>f2, 2: f1<f2, 0: f1=f2 */
function comparafecha(fecha1, fecha2){
  if ( !checkdate(fecha1) || !checkdate(fecha2) ) return -1;
  dia = fecha1.substring(0,2)
  mes = fecha1.substring(3,5)
  anho = fecha1.substring(6,10)
  fecha1x = anho + mes + dia
  dia = fecha2.substring(0,2)
  mes = fecha2.substring(3,5)
  anho = fecha2.substring(6,10)
  fecha2x = anho + mes + dia
  return (fecha1x>fecha2x?1:(fecha1x<fecha2x?2:0));
}
function nada(){}
function corta(campo, longitud, cars) {
  if (campo.value.length>longitud) campo.value=campo.value.substring(0,longitud);
  cuenta(campo, cars);
}
function cuenta(campo, cars) { cars.value=campo.value.length; }
function rellena(dato, caracter, tamanho){
  dato_trim = trim(dato);
  len = dato_trim.length;
  dato_fill = "";
  for (var i=0;i<tamanho-len;i++){ dato_fill+=caracter; }
  dato_fill+=dato_trim;
  return dato_fill;
}
function checkdate(fecha){
  var err=0
  if ( fecha.length != 10) err=1
  dia = fecha.substring(0,2)
  slash1 = fecha.substring(2,3)
  mes = fecha.substring(3,5)
  slash2 = fecha.substring(5,6)
  anho = fecha.substring(6,10)
  if ( dia<1 || dia>31) err = 1
  if ( slash1 != '/' ) err = 1
  if ( mes<1 || mes>12) err = 1
  if ( slash1 == '/' && slash2 != '/' ) err = 1
  if ( anho < 0 || anho > 2200 ) err = 1
  if ( mes == 4 || mes == 6 || mes == 9 || mes == 11 ){
    if (dia==31) err=1
  }
  if (mes == 2){
    var g = parseInt(anho/4)
    if (isNaN(g)){
      err = 1
    }
    if (dia >29) err =1
    if (dia ==29 && ((anho/4)!=parseInt(anho/4))) err=1
  }
  return (!(err==1));
}
function esnulo(campo){ return (campo == null||campo=="");}
function esnulooguion(campo){
  return esnulo(campo) || ( trim( campo ) == "-" );
}
function esnumero(campo){ return (!(isNaN( campo )));}
function longitudcorrecta( campo, len ){
  if ( campo != null ) return ( campo.length == len );
  else return false;
}
function mayuscula(campo){return campo.toUpperCase();}
function minuscula(campo){return campo.toLowerCase();}
function eslongrucok(ruc){return ( ruc.length == 11 );}
function eslongcontrasenhaok(contrasenha){
  return (contrasenha.length >= longcontrasenhaok());
}
function longcontrasenhaok(){ return 6;}
function esnegativo(valor){ return (valor < 0);}
function esrucok(ruc){
  return (!( esnulo(ruc) || !esnumero(ruc) || !eslongrucok(ruc) || !valruc(ruc) ));
}
function valruc(valor){
  valor = trim(valor)
  if ( esnumero( valor ) ) {
    if ( valor.length == 8 ){
      suma = 0
      for (i=0; i<valor.length-1;i++){
        digito = valor.charAt(i) - '0';
        if ( i==0 ) suma += (digito*2)
        else suma += (digito*(valor.length-i))
      }
      resto = suma % 11;
      if ( resto == 1) resto = 11;
      if ( resto + ( valor.charAt( valor.length-1 ) - '0' ) == 11 ){
        return true
      }
    } else if ( valor.length == 11 ){
      suma = 0
      x = 6
      for (i=0; i<valor.length-1;i++){
        if ( i == 4 ) x = 8
        digito = valor.charAt(i) - '0';
        x--
        if ( i==0 ) suma += (digito*x)
        else suma += (digito*x)
      }
      resto = suma % 11;
      resto = 11 - resto
      
      if ( resto >= 10) resto = resto - 10;
      if ( resto == valor.charAt( valor.length-1 ) - '0' ){
        return true
      }      
    }
  }
  return false
}
function longitudmayor( campo, len ){
  return ( campo != null )? (campo.length > len) : false;
}
function estaentre(campo, inicio, fin){
  if ( campo != null ) return ( campo.length >= inicio && campo.length <= fin );
  else return false;
}
var sorry="SUNAT - Derechos Reservados� 2004";
function click(e){
   if (document.all) if (event.button == 2){alert(sorry);return false;} 
   if (document.layers) if (e.which == 3){alert(sorry);return false;}
}
if (document.layers){ document.captureEvents(Event.MOUSEDOWN);}
document.onmousedown=click;
function abreventana(i, j) {
  window.open(i, j, "toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=yes,copyhistory=0,width=600,height=450")
}
var da = (document.all) ? 1 : 0;
var pr = (window.print) ? 1 : 0;
var mac = (navigator.userAgent.indexOf("Mac") != -1); 
function printPage(frame, arg) {
  if (frame == window){printThis();}
  else {link = arg; printFrame(frame); }
  return false;
}
function printThis() {
  if (pr) { // NS4, IE5
    window.print();
  } else if (da && !mac) { // IE4 (Windows)
    vbPrintPage();
  } else { // other browsers
    alert("Disculpe, su browser no soporta esta aplicacion.");
  }
}
function trim(cadena){
  cadena2 = "";
  len = cadena.length;
  for ( var i=0; i <= len ; i++ ) if ( cadena.charAt(i) != " " ){cadena2+=cadena.charAt(i); }
  return cadena2;
}
function printFrame(frame) {
  if (pr && da) { // IE5
    frame.focus();
    window.print();
    link.focus();
  } else if (pr) { // NS4
    frame.print();
  } else if (da && !mac) { // IE4 (Windows)
    frame.focus();
    setTimeout("vbPrintPage(); link.focus();", 100);
  } else { // other browsers
    alert("Disculpe, su browser no soporta esta aplicacion.");
  }
}
if (da && !pr && !mac) with (document) {
  writeln('<'+'OBJECT ID="WB" WIDTH="0" HEIGHT="0" CLASSID="clsid:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>');
  writeln('<'+'SCRIPT LANGUAGE="VBScript">');
  writeln('Sub window_onunload');
  writeln('  On Error Resume Next');
  writeln('  Set WB = nothing');
  writeln('End Sub');
  writeln('Sub vbPrintPage');
  writeln('  OLECMDID_PRINT = 6');
  writeln('  OLECMDEXECOPT_DONTPROMPTUSER = 2');
  writeln('  OLECMDEXECOPT_PROMPTUSER = 1');
  writeln('  On Error Resume Next');
  writeln('  WB.ExecWB OLECMDID_PRINT, OLECMDEXECOPT_DONTPROMPTUSER');
  writeln('End Sub');
  writeln('<'+'/SCRIPT>');
}

function validateEmail(entry){
  /**
     * INPUT:
     * entry --> direccion de correo electr�nico: eperez@terra.com.pe     
     * OUPUT:validado --> 1:ok, 0: fail , 2:  INFORMACI�N DE CORREO INCOMPLETA, CORREGIR, 3:   INFORMACI�N DE CORREO INCORRECTA, CORREGIR
     * author:mps
     * fecha:30/01/2015
     * */
     
  var myRegExp = /\b(^(\S+@).+((\.gob)|(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.biz)|(\.org)|(\..{2,15}))$)\b/gi;  
  var validado=0;  //0 FALSO, 1 OK, 2 OK pero se exige minimo 5 caracteres  
  var submail = entry.split("@");       
  var nombre = submail[0];  
  var dominio=submail[1];         
                      
  var listaPalabrasProhibidas = new Array("no+tengo+correo",
                      "no+tengo+coreo", 
                      "no_tengo_coreo",
                      "no_tengo_correo",
                      "no-tengo-correo",
                      "no-tengo-coreo", 
                      "no.tengo.coreo",                     
                      "no.tengo.correo" );

        if (nombre.length <3) {
          return validado=2;
        }                       

  if (myRegExp.test(entry)) {
  validado=1;   
  myRegExp= /((\S+@gmail)|(\S+@hotmail)|(\S+@yahoo)|(\S+@terra)|(\S+@latinmail)|(\S+@outlook))\b/gi;  
      if (myRegExp.test(entry)) {
                
        if(dominio.toUpperCase()=="HOTMAIL.COM.PE"){ //no deben terminar en ".com.pe" informacion incorrecta        
           return validado=3;  
        }
      }
        
      //valida si las palabras prohibidas
      for ( var i = 0; i < listaPalabrasProhibidas.length; i++ ) {  
          var item = listaPalabrasProhibidas[i];
        if(nombre.toUpperCase()==item.toUpperCase()){
        return validado=3;
        break;
        }
      }     
      var dominioNew=dominio.split(".");
      var subDominio=dominioNew[0];
      
      for ( var i = 0; i < listaPalabrasProhibidas.length; i++ ) {  
          var item = listaPalabrasProhibidas[i];
        if( (i==6 |i==7) && dominio.length>14)
        {subDominio=dominio.substring(0, 15);}
        if(subDominio.toUpperCase()==item.toUpperCase()){
        return validado=3;
        break;
        }
      }
    
      var item = listaPalabrasProhibidas[7];
      if(dominio.length>15){
        if(dominio.substring(0, 15).toUpperCase()==item.toUpperCase()){ 
            return  validado=3;  
           }        
      }     
      if(subDominio.length<2){ // subdominio no  debe tener menos de 2 caracteres     
        return validado=2;
      } 

      
  } 
  return validado;
} 


var gCount = 0;
var contPag = 0;
function goRefresh() {
 document.mainForm.codigo.value = "";
 document.mainForm.imagen.src="http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image&nmagic=" + gCount;

 //http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image&nmagic=
 gCount = gCount + 1;
}


function format(type) {
 var form = document.mainForm;
 if(type == 0) {
   document.getElementById('s1').style.visibility = 'visible'; 
   document.getElementById('s2').style.visibility = 'hidden';
   document.getElementById('s3').style.visibility = 'hidden';
   form.search1.maxLength = 11;
   form.search1.onkeypress = function(e) {
   if (!e) e=window.event;
   key = e.keyCode? e.keyCode : e.which>0?e.which:e.keyCode;
   if (key == 8 || key==9) return true;
   pattern =/[0-9]/;
   te = String.fromCharCode(key);
   return pattern.test(te);     
  }  
  form.search1.focus();
  form.search1.value = "";
  
 }
 if(type == 1) {
   document.getElementById('s2').style.visibility = 'visible'; 
   document.getElementById('s1').style.visibility = 'hidden';
   document.getElementById('s3').style.visibility = 'hidden';
   form.search2.maxLength = 16; 
   form.search2.onkeypress = function(e) {return true;}   
   form.search2.focus();
   form.search2.value = "";
 }
 
 if(type == 2) {
   document.getElementById('s3').style.visibility = 'visible'; 
   document.getElementById('s1').style.visibility = 'hidden';
   document.getElementById('s2').style.visibility = 'hidden';
   form.search3.maxLength = 100;
   form.search3.onkeypress = function(e) {return true;}   
   form.search3.focus();
   form.search3.value = "" ;
 }
 
// form.search.focus();
 //form.search.value = ""  ;
}

function verificaDocumento()
 {
   var form = document.mainForm;
   var   tipdoc = form.tipdoc.value;
   var    numdoc =form.search2.value;  
   if (tipdoc=="1")
    {
      if (numdoc.length!=8 )
       {
          alert("El número de documento de identidad debe tener 8 dígitos");      
          return false;
       }
     else{
        if ( !esnumero(numdoc) )
          {
             alert("El número de documento de identidad debe tener 8 dígitos");     
             return false;
          }
     }       
    } 
  return true; 
  }
  

function evalSearch() {
 var form = document.mainForm;
 if(form.tQuery[0].checked) {
  form.nroRuc.value = form.search1.value;
  form.accion.value = "consPorRuc";
  if(!esrucok(form.nroRuc.value)){
    alert('Por favor, ingrese numero de RUC valido.');form.search1.focus();return;
  }
 }
 else {
   if(form.tQuery[2].checked) {
     form.accion.value = "consPorRazonSoc";
     form.razSoc.value = form.search3.value;
     if(!longitudmayor(trim(form.razSoc.value),4) || (trim(form.razSoc.value).substring(0,1)=='*')){
       alert('La Razón social no es válida ...');form.search3.focus();return;
     }
   if ( validar(form.search3.value)==false){
      alert('Sólo puede ingresar letras y/o números como criterio de búsqueda ...');form.search3.focus();return;
   }  
   
   }else {//se trata del tipo y nro del documento
     form.nrodoc.value = form.search2.value;
     form.accion.value = "consPorTipdoc";
     if(!longitudmayor(trim(form.nrodoc.value),4) || (trim(form.nrodoc.value).substring(0,1)=='*')){
       alert('El Nro del documento no es válida ...');form.search2.focus();return;
     } 
    if (verificaDocumento()==false) return; 
    if ( validar2(form.search2.value)==false){
      alert('Sólo puede ingresar letras  y/o números como criterio de búsqueda ...');form.search2.focus();return;
    } 
   } 
   
 }
 if(form.contexto.value == 'ti-it'){
   if(trim(form.codigo.value).length < 4) {
     alert('Ingrese el código que se muestra en la imagen');form.codigo.focus();return;
   }
  }
 form.submit();
}
function   validar(texto) {
             x = true;
       //if (!/^([A-Za-z\s])*$/.test(texto)){ 
            if (!/^([A-Za-z0-9\s\361\321@\\&\\Ü\\ü\\-\\.\\,])*$/.test(texto)){               
                x = false;
             }
            return x; 
}
function   validar2(texto) {
             x = true;       
            if (!/^([A-Za-z0-9\\-\\.\\_])*$/.test(texto)){               
                x = false;
             }
            return x; 
}

function getContPag(){
return -contPag;
}
function incContPag(){
contPag=contPag+1;
}
function resetContPag(){
contPag=0;
}
</script>
<body bgcolor="#FFFFFF" onLoad="JavaScript:format(0)">
<!-- target="mainFrame" -->
<!-- http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" -->
  <form  method="post" name="mainForm" action="">

    <table class="form-table" cellSpacing="2" cellPadding="3" width="100%" border=0>
      <tbody>
        <tr>
          <td>
            <table cellSpacing="2" cellPadding="3" width="100%" border=0>
              <tbody>
                <tr>
                  <td bgcolor="#3399cc" align="left"> <b>CRITERIOS DE B&Uacute;SQUEDA:</b>
                  </td>
                </tr>
              </tbody>
            </table>
            <input type="hidden" name="accion" value="">
            <input type="hidden" name="razSoc" value="">
            <input type="hidden" name="nroRuc" value="">
            <input type="hidden" name="nrodoc" value="">
            <table cellSpacing="0" cellPadding="0" width="100%" border=0>
              <tbody>

                <input type="hidden" name="contexto" value="ti-it">
                <tr>
                  <td width="2%">
                    <input type="radio" name="tQuery" onclick="format(0)" checked></td>
                  <td class="bgn" width="20%">N&uacute;mero de RUC</td>

                  <td align="left" colspan="1" width="30%">
                    <div id="s1" style="visibility:hidden" >
                      <input class="form-text" name="search1" size="11"  ></div>
                  </td>

                  <!-- <td align="left" rowspan="1" width="180"></td>
                -->
                <td class="bgn" rowspan="1" width="20%" valign="middle">Ingrese el c&oacute;digo que se muestra en la imagen:</td>
                <td align="left" rowspan="1" width="13%">
                  <img name="imagen" src="http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image"/>
                </td>
                <td align="left" rowspan="1" width="10%" valign="center">
                  <input style="text-transform:uppercase;" type="text" name="codigo" maxlength="4" size="4" onChange="this.value=this.value.toUpperCase();"/>
                </td>
                <td rowspan="1" width="5%">
                  <input class="form-button" type="button" value="Buscar" onclick="evalSearch();"></td>
              </tr>
              <tr>
                <td >
                  <input type="radio" name="tQuery" onclick="format(1)"></td>
                <td class="bgn"  >
                  Tipo y N&uacute;mero de Documento de Identidad
                  <select size="1" name="tipdoc" >
                    <OPTION   value="1" >Documento Nacional de Identidad</OPTION>
                    <OPTION   value="4" >Carnet de Extranjeria</OPTION>
                    <OPTION   value="7" >Pasaporte</OPTION>
                    <OPTION   value="A" >Ced. Diplomatica de Identidad</OPTION>
                  </select>
                </td>

                <td align="left" colspan="1">
                  <div id="s2" style="visibility:hidden">
                    <input class="form-text" name="search2" size="16"></div>
                </td>

                <!--<td align="left" rowspan="1"  colspan="2" width="100"></td>
              -->
              <td rowspan="1" align="left" >
                <a href="javascript:goRefresh()">Refrescar codigo</a>
              </td>
            </tr>

            <tr>
              <td>
                <input type="radio" name="tQuery" onclick="format(2)">
                <input type="hidden" name="coddpto" value="">
                <input type="hidden" name="codprov" value="">
                <input type="hidden" name="coddist" value=""></td>
              <td class="bgn"  >Nombre &oacute; Raz&oacute;n Social</td>

              <td align="left" colspan="4" >
                <div id="s3" style="visibility:hidden"  >
                  <input class="form-text" name="search3" size="30"></div>
              </td>

            </tr>

          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
</form>


  <iframe src="" name="mainFrame" ></iframe>

</body>
</html>