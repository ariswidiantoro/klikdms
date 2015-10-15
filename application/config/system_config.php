<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configuration of System
|--------------------------------------------------------------------------
*/
$config['name_system']  =   "Sun Motor Aplications System";
$config['company']	    =   "Sun Motor Group";
$config['address']      =   "Jl. Kolonel Sutarto No. 19, Surakarta";
$config['telepon']      =   "(0271) 647444";
$config['version']	    =   "Beta (2.0)";
$config['developer']	=   "IST Development";	

/**
|--------------------------------------------------------------------------
| configuration position of employees
|--------------------------------------------------------------------------
*/
//Finance
define("dept_finance",1);
//Service
define("dept_service",2);
//spare Part
define("dept_spare_part", 3);
//Back Office
define("dept_back_office", 4);
//PGA
define("dept_pga", 5);
//Accounting
define("dept_accounting", 6);
//Marketing
define("dept_marketing", 7);
//Audit
define("dept_audit", 8);
//IST
define("dept_ist", 9);
//Development
define("dept_development", 10);
//Body Repair
define("dept_body_repair", 11);
/**
|--------------------------------------------------------------------------
| configuration position of employees
|--------------------------------------------------------------------------
*/

/**
|--------------------------------------------------------------------------
| configuration detail position of employees
|--------------------------------------------------------------------------
*/
//IST Developer
define("pos_ist_developer",1);
//Admin Service
define("pos_admin_service",2);
//Kasir Sales
define("pos_kasir_sales",3);
//Foreman
define("pos_foreman_service",4);
//ADH
define("pos_adh",5);
//Supervisor Akuntansi
define("pos_supervisor_akuntansi",6);
//IST Supervisor
define("pos_ist_supervisor",8);
//Admin Spare Part
define("pos_admin_spart",10);
//Sales Manager
define("pos_sales_manager",11);
//Supervisor Sales
define("pos_supervisor_sales",13);
//Kasir Service
define("pos_kasir_service",14);
//Brand Manager
define("pos_branch_manager",15);
//IST Staff
define("pos_ist_staff",16);
//General manager
define("pos_general_manager_ssm",17);
//Sales Executive
define("pos_sales_executive",19);
//Sales Counter Senior
define("pos_sales_counter_senior",20);
//Sales Junior
define("pos_sales_junior",21);
//Sales Senior
define("pos_sales_senior",22);
//Sales Counter Junior
define("pos_sales_counter_junior",23);
//Service Advisor
define("pos_service_advisor",24);
//Admin Sales
define("pos_admin_sales",25);
//General Manager SM
define("pos_general_manager_sm", 26);
//Direktur SSM
define("pos_direktur_ssm", 27);
//Direktur SM
define("pos_direktur_sm", 28);
//Direksi Finance
define("pos_direksi_finance", 29);
//Supervisor Kanwil
define("pos_supervisor_kanwil", 30);
//Staff kanwil
define("pos_staff_kanwil", 31);
//Salses Spare Part
define("pos_sales_spare_part", 32);
//Mekanik
define("pos_mekanik", 33);
//Final Checker
define("pos_final_checker", 34);
//Kasir Part
define("pos_kasir_part", 35);

/**
|--------------------------------------------------------------------------
| configuration of menu
|--------------------------------------------------------------------------
*/
//Sales
define("menu_sales", 1);
//service
define("menu_service", 2);
//spare part
define("menu_spare_part", 3);
//control panel
define("menu_control_panel", 4);
//master sales
define("menu_master_sales", 5);
//master sales merk kendaraan
define("menu_merk_kendaraan", 6);
//master sales tipe kendaraan
define("menu_tipe_kendaraan", 7);
//master sales warna kendaraan
define("menu_warna_kendaraan", 8);
//master sales pelanggan
define("menu_pelanggan_sales", 9);
//master sales supplier
define("menu_supplier", 10);
//master sales karoseri
define("menu_karoseri", 11);
//master sales salesman
define("menu_salesman", 12);


?>