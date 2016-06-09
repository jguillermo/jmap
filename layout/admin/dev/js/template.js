(function() {angular.module('Admin.template', []).run(['$templateCache', function($templateCache) {  'use strict';

  $templateCache.put('/app/views/dashboard/index.html',
    "<div class=row><div class=\"col-xs-6 col-sm-6\"><jgc-card><div class=card-link><a href=\"\" data-ui-sref=sis.user>Personas<span class=icon><i class=material-icons>&#xE315;</i></span></a></div></jgc-card></div></div>"
  );


  $templateCache.put('/app/views/sis/layout-admin.html',
    "<jgc-layout jgt-component-id=layout_principal><jgc-layout-west><jgc-tool-bar class=primary><div class=pull-left><div class=\"btn-tool-bar visible-xs-block\"><button class=\"btn btn-default\" ng-click=changePrincipalWest()><i class=material-icons>menu</i></button></div><div class=title-tool-bar>JGTOOLS</div></div></jgc-tool-bar><jgc-menu items=itemenu></jgc-menu></jgc-layout-west><jgc-layout-center><jgc-tool-bar class=primary><div class=pull-left><div class=btn-tool-bar><button class=\"btn btn-default\" ng-click=changePrincipalWest()><i class=material-icons>menu</i></button></div><div class=title-tool-bar jgc-title>&nbsp;</div></div></jgc-tool-bar><div class=\"content container-fluid\" style=padding-top:30px><div ui-view></div></div></jgc-layout-center></jgc-layout>"
  );


  $templateCache.put('/app/views/user/edit-new.html',
    "<style>.jgc-block{\r" +
    "\n" +
    "\tbackground-color: rgba(255, 255, 255, 0);\r" +
    "\n" +
    "\tposition: absolute;\r" +
    "\n" +
    "\ttop: 0;\r" +
    "\n" +
    "\tright: 0;\r" +
    "\n" +
    "\tbottom: 0;\r" +
    "\n" +
    "\tleft: 0;\r" +
    "\n" +
    "\tz-index: 5;\r" +
    "\n" +
    "}\r" +
    "\n" +
    ".row-condensed > div > .btn-delete{\r" +
    "\n" +
    "\tcolor: #d9534f;\r" +
    "\n" +
    "\tmargin: 0 -8px;\r" +
    "\n" +
    "    padding: 8px 5px;\r" +
    "\n" +
    "}\r" +
    "\n" +
    ".row-condensed > div > .btn-delete i{\r" +
    "\n" +
    "\tfont-size: 18px;\r" +
    "\n" +
    "}\r" +
    "\n" +
    ".row-condensed .row-condensed{\r" +
    "\n" +
    "\tmargin-left: -8px;\r" +
    "\n" +
    "    margin-right: -8px;\r" +
    "\n" +
    "}\r" +
    "\n" +
    ".removeform select.form-control{\r" +
    "\n" +
    "   background-image:none;     \r" +
    "\n" +
    "}\r" +
    "\n" +
    ".removeform .form-control {\r" +
    "\n" +
    "\tborder-color: #FFF;\r" +
    "\n" +
    "}\r" +
    "\n" +
    ".removeform  .form-control:focus {\r" +
    "\n" +
    "  border-color: #FFF;\r" +
    "\n" +
    "}</style><section class=user-edit-new><jgc-card><div class=\"card-section text-center\"><i class=material-icons>person</i></div><jgc-menu-horizontal><div class=\"jgc-mh-item active\">Datos</div><div class=jgc-mh-item>Asociación</div><div class=jgc-mh-item>Pedidos</div><div class=jgc-mh-item>Preguntas</div></jgc-menu-horizontal></jgc-card><form action=\"\" name=frm_edit_new_user_datos><jgc-card><h3 class=card-title>Datos Personales <a ng-hide=block.datos.isEdit class=\"btn btn-default btn-xs pull-right\" ng-click=\"block.datos.isEdit=true\" class=pull-right>Editar</a></h3><div jgc-block jg-block-enable={{!block.datos.isEdit}} jg-block-type=2 class=\"row row-condensed\" ng-class={removeform:!block.datos.isEdit}><div class=col-xs-6 ng-class=\"{'has-error': frm_edit_new_user_datos.user_tipdoc.$touched && frm_edit_new_user_datos.user_tipdoc.$invalid}\"><select class=form-control name=user_tipdoc ng-options=\"identityType.id as identityType.name  for identityType in identityTypes\" ng-model=user.identityType_id required><option class=select-info value=\"\">Tipo de Documento</option></select><div ng-messages=\"frm_edit_new_user_datos.user_tipdoc.$touched && frm_edit_new_user_datos.user_tipdoc.$error\"><div ng-messages-include=app-custom-messages></div></div></div><div class=col-xs-6 ng-class=\"{'has-error': frm_edit_new_user_datos.user_numdoc.$touched && frm_edit_new_user_datos.user_numdoc.$invalid}\"><input name=user_numdoc class=form-control ng-model=user.identityNumber placeholder=\"Nº Documento\" required><div ng-messages=\"frm_edit_new_user_datos.user_numdoc.$touched && frm_edit_new_user_datos.user_numdoc.$error\"><div ng-messages-include=app-custom-messages></div></div></div><div class=col-xs-12 ng-class=\"{'has-error': frm_edit_new_user_datos.user_name.$touched && frm_edit_new_user_datos.user_name.$invalid}\"><input class=form-control name=user_name ng-model=user.name placeholder=Nombre required><div ng-messages=\"frm_edit_new_user_datos.user_name.$touched && frm_edit_new_user_datos.user_name.$error\"><div ng-messages-include=app-custom-messages></div></div></div><div class=col-xs-6 ng-class=\"{'has-error': frm_edit_new_user_datos.user_lastName.$touched && frm_edit_new_user_datos.user_lastName.$invalid}\"><input class=form-control name=user_lastName ng-model=user.lastName placeholder=\"Ap. Paterno\" required><div ng-messages=\"frm_edit_new_user_datos.user_lastName.$touched && frm_edit_new_user_datos.user_lastName.$error\"><div ng-messages-include=app-custom-messages></div></div></div><div class=col-xs-6 ng-class=\"{'has-error': frm_edit_new_user_datos.user_secondLastName.$touched && frm_edit_new_user_datos.user_secondLastName.$invalid}\"><input class=form-control name=user_secondLastName ng-model=user.secondLastName placeholder=\"Ap. Materno\"><div ng-messages=\"frm_edit_new_user_datos.user_secondLastName.$touched && frm_edit_new_user_datos.user_secondLastName.$error\"><div ng-messages-include=app-custom-messages></div></div></div></div><div ng-if=block.datos.isEdit class=\"row jgt-padding-bottom-20\"><div class=col-xs-6><a class=\"btn btn-primary btn-block\" role=button><i ng-show=frm_edit_new_user_datos.$invalid class=material-icons>error</i> <i ng-show=frm_edit_new_user_datos.$valid class=material-icons>check</i> Guardar</a></div><div class=col-xs-6><a class=\"btn btn-default btn-block\" ng-click=\"block.datos.isEdit=false\" role=button>Cancelar</a></div></div></jgc-card></form><form action=\"\" name=frm_edit_new_user_phone><jgc-card><h3 class=card-title>Teléfono <a ng-hide=block.phone.isEdit class=\"btn btn-default btn-xs pull-right\" ng-click=\"block.phone.isEdit=true\" class=pull-right>Editar</a></h3><div jgc-block jg-block-enable={{!block.phone.isEdit}} jg-block-type=2 class=\"row row-condensed\" ng-class={removeform:!block.phone.isEdit}><div class=col-xs-12 ng-repeat=\"phone in user.phone\"><div class=\"row row-condensed\"><div class=col-xs-1 ng-if=block.phone.isEdit><a href class=\"btn btn-delete\" ng-click=deletePhone($index)><i class=material-icons>remove_circle</i></a></div><div class=col-xs-5 ng-class=\"{'has-error': frm_edit_new_user_phone.user_phone_type_{{$index}}.$touched && frm_edit_new_user_phone.user_phone_type_{{$index}}.$invalid}\"><select class=form-control name=user_phone_type_{{$index}} ng-options=\"phoneType.id as phoneType.name  for phoneType in phoneTypes\" ng-model=phone.phone_type_id required><option class=select-info value=\"\">Seleccionar</option></select><div ng-messages=\"frm_edit_new_user_phone['user_phone_type_' + $index].$touched && frm_edit_new_user_phone['user_phone_type_'+$index].$error\"><div ng-messages-include=app-custom-messages></div></div></div><div class=col-xs-6 ng-class=\"{'has-error': frm_edit_new_user_phone.user_phone_number_{{$index}}.$touched && frm_edit_new_user_phone.user_phone_number_{{$index}}.$invalid}\"><input class=form-control name=user_phone_number_{{$index}} ng-model=phone.number ng-pattern=block.phone.validator[phone.phone_type_id].pattern placeholder=\"\" required><div ng-messages=\"frm_edit_new_user_phone['user_phone_number_' + $index].$touched && frm_edit_new_user_phone['user_phone_number_'+$index].$error\"><p class=help-block ng-message=pattern>{{block.phone.validator[phone.phone_type_id].pattern_msg}}</p><div ng-messages-include=app-custom-messages></div></div></div></div></div></div><div class=card-link ng-if=block.phone.isEdit><a href=\"\" ng-click=addphone() ng-disabled=block.phone.loading ng-class=\"{'loading':block.phone.loading}\">Añadir teléfono <span class=icon><i class=material-icons>add</i></span> <span ng-show=block.phone.loading><i class=\"fa fa-spinner fa-spin\"></i></span></a></div><div ng-if=block.phone.isEdit class=\"row jgt-padding-bottom-20\"><div class=col-xs-6><a class=\"btn btn-primary btn-block\" role=button><i ng-show=frm_edit_new_user_phone.$invalid class=material-icons>error</i> <i ng-show=frm_edit_new_user_phone.$valid class=material-icons>check</i> Guardar</a></div><div class=col-xs-6><a class=\"btn btn-default btn-block\" ng-click=\"block.phone.isEdit=false\" role=button>Cancelar</a></div></div></jgc-card></form></section>"
  );


  $templateCache.put('/app/views/user/index.html',
    "<section id=user-list class=\"page panel panel-primary\"><div class=panel-heading><a class=\"btn btn-primary\" href=\"#/\" role=button><i class=\"fa fa-long-arrow-left\"></i></a> personas</div><div></div></section>"
  );


  $templateCache.put('/app/views/user/list.html',
    "<div class=app-user><jgc-card><div class=card-section><div class=form-search><form ng-submit=buscarPersona()><div class=\"input-group input-group-sm\"><input type=search ng-model=search.value class=form-control placeholder=Buscar> <span class=input-group-btn><button class=\"btn btn-default\" type=submit><i class=\"fa fa-search\"></i></button></span></div></form></div></div></jgc-card><jgc-card><ul class=card-list><li class=item ng-repeat=\"user in users\"><a href=\"\" ui-sref=\"sis.user_editar({ userID: user.id })\"><div class=\"row show-grfghgdfg\"><div class=col-xs-12><div class=row><div class=\"col-xs-12 col-sm-6\">{{ user.name }} {{user.lastName}} {{user.secondLastName}}</div><div class=\"col-xs-12 col-sm-6\"><small>{{user.identityType}}: {{user.identityNumber}}</small></div></div></div></div></a></li></ul><div class=card-section><div class=text-center ng-if=\"users.length==0 && yasebusco\">no hay personas</div><div class=text-center ng-if=!users><i class=\"fa fa-spinner fa-pulse fa-4x\"></i></div></div></jgc-card></div>"
  );
}]);})();