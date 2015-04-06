<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    /**
    * @author  : YP
    * @link    : https://timexstudio.com
    * @license : Protected
    * @author  : purwantoyudi42@gmail.com
    */
        
class Ex_datatables extends CI_Controller {

        
        public function __construct() {

        parent::__construct();
        $this->classes =strtolower(__CLASS__);
        $this->load->library(array( 'datatable_ssp','datatable_ssp_join'));
        }

    public function list() {

        $table = 'product';

        $primaryKey = 'Prodid';

        $columns = array(
            array('db' => '`Prodid`', 'dt' => 0, 'field' => 'Prodid'),
            array('db' => '`Prod_code`', 'dt' => 1, 'field' => 'Prod_code'),
            array('db' => '`Prod_name`', 'dt' => 2, 'field' => 'Prod_name'),
            array('db' => '`Prod_desc`', 'dt' => 3, 'field' => 'Prod_desc'),
            array('db' => '`Prod_packing`', 'dt' => 4, 'field' => 'Prod_packing'),
            array('db' => '`Prod_main`', 'dt' => 5, 'field' => 'Prod_main'),
            array('db' => '`Prod_min`', 'dt' => 6, 'field' => 'Prod_min'),
            array('db' => '`Prod_status`', 'dt' => 7, 'formatter' => function( $d, $row ) {
                $result ="";
                if($row['Prod_status']=="Y") {
                    $result ="<div class='btn btn-success'>Y</div>";
                } else {
                    $result ="<div class='btn btn-danger'>N</div>";
                }
                return $result;
            },
            'field' => 'Prod_status'),
             array('db' => '`Prodid`', 'dt' => 8, 'formatter' => function( $d, $row ) {
                return "<a href='".base_url()."apollo/update/".$row['Prodid']."'><i class='btn btn-info fa fa-edit'></i></a> | <a href='".base_url()."apollo/destroy/".$row['Prodid']."'><i class='btn btn-danger fa fa-remove'></i></a>";
            }, 
            'field' => 'Prodid' )
        );

        $joinQuery ="FROM `product`";

        echo json_encode(
            $this->datatable_ssp_join->simple( $_GET, $table, $primaryKey, $columns, $joinQuery)
            );
    }


}