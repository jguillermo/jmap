<?php

namespace Wread\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AppController extends BaseController
{

    public function __construct()
    {   
       parent::__construct();
    }

    public function layoutAction()
    {
       return new ViewModel();
    }

    public function readWebAction()
    {
       return new ViewModel();
    }
    public function readWebModalAction()
    {
       return new ViewModel();
    }
    public function readWebSqlAction()
    {
       return new ViewModel();
    }

    public function saveguidAction(){
       
        $datos = json_decode(file_get_contents("php://input"),true);



        //var_dump($datos);exit();
       $id=$datos['id'];


        $columns="";
        $columns_insert="";
        
        $values="";
        
        foreach ($datos['result'][0] as $key => $row) {
           $ncol=$key+1;
           $columns.=" `col{$ncol}` varchar(100) DEFAULT NULL,";
           $columns_insert.="`col{$ncol}`,";
        }
        
        foreach ($datos['result'] as $key => $row) {
           
           $rowValue="";
           foreach ($row as $val) {
             $valf=str_replace("'", "\\'",$val );
             $rowValue.="'{$valf}',";
           }
        
           $rowValue=rtrim($rowValue,",");
           $values.="({$rowValue}),";
        }
        
        
        $columns_insert=rtrim($columns_insert,",");
        $values=rtrim($values,",");
        
        
        $sql="DROP TABLE IF EXISTS `msi-{$id}`;
        CREATE TABLE `msi-{$id}` (  
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          {$columns}
          `id_lugar` int(11) DEFAULT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        
        INSERT INTO `wread`.`msi-{$id}`({$columns_insert})VALUES $values ;
        
        ";

        $adapter = \Jmap\Model\Adapter::getAdapter('msi');

        $statement = $adapter->query($sql);

        $statement->execute();


       return new JsonModel(array(
          'sql' => 'se guardo en la base de datos',
        ));
    }
}
