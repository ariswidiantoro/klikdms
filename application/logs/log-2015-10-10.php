ERROR - 2015-10-10 08:48:27 --> Severity: Warning  --> pg_query(): Query failed: ERROR:  syntax error at or near &quot;WHEN&quot;
LINE 1: ...de&quot;, &quot;prosid&quot;, &quot;pros_nama&quot;, &quot;pros_alamat&quot;, &quot;CASE&quot; WHEN fpt_a...
                                                             ^ C:\xampp\htdocs\klikdms\system\database\drivers\postgre\postgre_driver.php 177
ERROR - 2015-10-10 08:48:27 --> CEK : SELECT "fptid", "fpt_kode", "prosid", "pros_nama", "pros_alamat", "CASE" WHEN fpt_approve = 1 THEN 'DISETUJUI' 
 WHEN fpt_approve = 2 THEN 'DITOLAK'
 ELSE 'PROSES' END as fpt_status, "pros_salesman", "pros_hp", "fpt_tgl", "kr_nama", "cty_deskripsi"
FROM "pen_fpt"
LEFT JOIN "pros_data" ON "prosid" = "fpt_prosid"
LEFT JOIN "pros_data_car" ON "car_prosid" = "fpt_prosid"
LEFT JOIN "ms_car_type" ON "ctyid" = "car_ctyid"
LEFT JOIN "ms_karyawan" ON "krid" = "pros_salesman"
WHERE "fpt_cbid" =  '100085'
ORDER BY "fptid" asc
LIMIT 10
ERROR - 2015-10-10 09:09:42 --> Severity: Notice  --> Undefined variable: wh C:\xampp\htdocs\klikdms\application\models\model_prospect.php 264
ERROR - 2015-10-10 09:11:10 --> AAAAAAAAa SELECT * FROM ms_user_role LEFT JOIN ms_role_det ON userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid WHERE menu_parent_id = -1 AND userro_krid = 'KR20001' ORDER BY menu_urut ASC
ERROR - 2015-10-10 09:11:10 --> AAAAAAAAa SELECT * FROM ms_user_role LEFT JOIN ms_role_det ON userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid WHERE menu_parent_id = -1 AND userro_krid = 'KR20001' ORDER BY menu_urut ASC
ERROR - 2015-10-10 09:11:17 --> AAAAAAAA SELECT menu_nama,menu_parent_id,menuid,menu_icon,menu_deskripsi,menu_url FROM ms_user_role LEFT JOIN ms_role_det ON userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid WHERE menu_parent_id != -1 AND menu_module = 1057 AND userro_krid = 'KR20001' ORDER BY menu_urut, menuid ASC
ERROR - 2015-10-10 09:11:49 --> AAAAAAAAa SELECT * FROM ms_user_role LEFT JOIN ms_role_det ON userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid WHERE menu_parent_id = -1 AND userro_krid = 'KR20001' ORDER BY menu_urut ASC
ERROR - 2015-10-10 09:11:49 --> AAAAAAAAa SELECT * FROM ms_user_role LEFT JOIN ms_role_det ON userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid WHERE menu_parent_id = -1 AND userro_krid = 'KR20001' ORDER BY menu_urut ASC
ERROR - 2015-10-10 09:11:54 --> AAAAAAAA SELECT menu_nama,menu_parent_id,menuid,menu_icon,menu_deskripsi,menu_url FROM ms_user_role LEFT JOIN ms_role_det ON userro_roleid = roledet_roleid LEFT JOIN ms_menu ON menuid = roledet_menuid WHERE menu_parent_id != -1 AND menu_module = 1057 AND userro_krid = 'KR20001' ORDER BY menu_urut, menuid ASC
ERROR - 2015-10-10 09:12:45 --> 404 Page Not Found --> transaksi_prospect/editFpt
ERROR - 2015-10-10 09:14:36 --> 404 Page Not Found --> transaksi_prospect/detailFpt
