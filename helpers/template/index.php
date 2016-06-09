<!DOCTYPE html>
<html lang="es" ng-app="Admin">
<head>
  <meta charset="utf-8">
    <title page-title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php 
    $entorno='development';

    $folderPublic = rtrim($_SERVER['SCRIPT_NAME'], 'index.php');


    if($entorno=='development') {

        $base_url=$folderPublic."f/admin-dev/";

        //var_dump($_SERVER['SCRIPT_NAME'], $folderPublic,$base_url); exit();
        $headLink=array(
            //'https://fonts.googleapis.com/css?family=Roboto:400,700,400italic',
            $base_url.'plugin/font-awesome/css/font-awesome.css',
            //$base_url.'plugin/bootstrap/css/bootstrap.css',
            //$base_url.'plugin/bootstrap/css/bootstrap-theme.css',
            $base_url.'plugin/angular-bootstrap/ui-bootstrap-csp.css',
            $base_url.'css/app.skin-1.css?'.rand(),
        );    
        $headScript=array(
            $base_url.'plugin/jquery/jquery.js',
            $base_url.'plugin/angular/angular.js',
            $base_url.'plugin/angular-animate/angular-animate.js',
            $base_url.'plugin/angular-touch/angular-touch.js',
            $base_url.'plugin/angular-messages/angular-messages.js',
            $base_url.'plugin/angular-ui-router/angular-ui-router.js',
            $base_url.'plugin/angular-bootstrap/ui-bootstrap-tpls.js',
            $base_url.'plugin/jtools/service-angularjs/jtools-services-angularjs.js',
            $base_url.'plugin/jtools/google-chart-angularjs/jtools-google-chart-angularjs.js',
            $base_url.'js/app.js',
        );
        $jsapiScript = $base_url.'plugin/jtools/jsapi/jsapi.js';

    }else{
        $base_url=$folderPublic."f/admin/";
        $headLink=array(
            'https://fonts.googleapis.com/css?family=Roboto:400,700,400italic',
            'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
            'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
            $base_url.'css/app'.$this->nAppBuild.'.min.css',
        );
        $headScript=array(
            'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
            'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js',
            'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.min.js',
            'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-touch.min.js',
            'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-messages.min.js',
            $base_url.'js/app'.$this->nAppBuild.'.min.js'
        );
        
        $jsapiScript = $base_url.'js/jsapi'.$this->nAppBuild.'.min.js';
    }


    $memoriaCache=array();

    foreach ($headLink as $key => $value) {
        $memoriaCache[]='adm_template_jtlc'.md5($value);
    }

    ?>
</head>
<body class="skin-1">
    <div ui-view></div>
    <?php //echo $this->content; ?>
<?php //echo $this->url('application',array('controller'=>'user')); ?>
    <script type="text/javascript" >
    var jsApiLoadLink=<?php echo json_encode($headLink)?>;
    var jsApiLoadScript=<?php echo json_encode($headScript)?>;

    //var jsApiLoadLinkCache=<?php echo json_encode($memoriaCache)?>;

    function jsApiLoad(){
        angular.module('Admin.config', [])
        .constant("ADM_ROUTES", {
            "view_url": "<?php echo $folderPublic?>app/views/",
            "view_sufix": ".html",
            "base_url": "<?php echo $folderPublic?>app/",
            "prefix": "adm_template_"
        });
    }
    </script>
    <script type="text/javascript" charset="utf-8" src="<?php echo $jsapiScript?>" async ></script>
    <script type="text/ng-template" id="app-custom-messages">
        <p class="help-block" ng-message="required">Este campo es requerido</p>
        <p class="help-block" ng-message="minlength">Este campo es demasiado corto</p>
    </script>
    </body>
</html>