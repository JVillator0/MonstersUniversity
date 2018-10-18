-- para crear el usario de bases de datos de un solo
GRANT USAGE ON *.* TO 'monsters_dba'@'localhost' IDENTIFIED BY PASSWORD '*3D3F2942EBEDD56DF252F3AF286FD7D8811BA82F';

GRANT ALL PRIVILEGES ON `monsters\_university\_db`.* TO 'monsters_dba'@'localhost' WITH GRANT OPTION;