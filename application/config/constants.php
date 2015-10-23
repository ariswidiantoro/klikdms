<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');
define('DEFAULT_TGL',		'01-01-9999');

define('JAB_SVC_MEKANIK', 'JAB002');
define('JAB_SVC_SA_FRONTMAN', 'JAB003');
define('JAB_SVC_FINAL_CHECKER', 'JAB004');
define('JAB_SVC_KASIR_SERVICE', 'JAB005');
define('JAB_MKT_SALES', 'JAB006');
define('JAB_MKT_SPVSALES', 'JAB007');
define('JAB_MKT_GMOSALES', 'JAB007');

// NUMERATOR KODE
define('NUM_INVOICE', 'IV');
define('NUM_TERIMA_BARANG', 'TB');
define('NUM_RETUR_JUAL_SPAREPART', 'RJ');
define('NUM_RETUR_BELI_SPAREPART', 'RB');
define('NUM_NOTA_SPAREPART', 'NS');
define('NUM_NUMERATOR_SPAREPART', 'NC');
define('NUM_SUPPLY_PK', 'SS');
define('NUM_SUPPLY_NOMER', 'SP');
define('NUM_ADJUSTMENT_STOCK', 'AD');

/* Rossi */
define('NUM_TIPE_JURNAL', 'TJ');
define('NUM_SETTING_JURNAL', 'SJ');
define('NUM_PROSPECT', 'PC');
define('NUM_STOCK_UNIT', 'ST');
define('NUM_BPK', 'BP');
define('NUM_SPK', 'SK');
define('NUM_FPT', 'FP');
define('NUM_TRANS', 'TR');

define('NUM_JENIS_COA', 'JC');
define('NUM_SPECIAL_COA', 'SC');

define('DEPT_SALES', '1');
define('DEPT_SERVICE', '2');
define('DEPT_SPART', '3');
define('DEPT_BREPAIR', '4');

define('TR_UM_UNIT', '1');
define('TR_UM_SERVICE', '2');
define('TR_UM_SPART', '3');
define('TR_UM_BREPAIR', '4');
define('TR_BYR_PIU_UNIT', '5');
define('TR_BYR_PIU_SERVICE', '6');
define('TR_BYR_PIU_SPART', '7');
define('TR_BYR_PIU_BREPAIR', '8');
define('TR_BYR_HUT_UNIT', '9');
define('TR_BYR_HUT_SPART', '10');
define('TR_NOTA_KREDIT', '11');






/* End of file constants.php */
/* Location: ./application/config/constants.php */
