<? 


$install_swp=0; // Push install script for DB. Set 0 after complete installation!

# Data for connect to mysql
$databasename="aromanuq_whohelp";
$dbadmin_login="aromanuq_whohelp";
$dbadmin_pass="Z?5s{B9]65##&Y7o";

# General prefix for all tables
$tableprefix="whohelp";

/* Для мультипл коннекшн
$alldbs=array(
	"HOSTNAME1"=>"192.168.1.1",
	"HOSTNAME2"=>"192.168.1.2",
	"HOSTNAME3"=>"192.168.1.3",
	"HOSTNAME4"=>"192.168.1.4",
	"HOSTNAME5"=>"192.168.1.5",
	"HOSTNAME6"=>"192.168.1.6",
	"HOSTNAME7"=>"192.168.1.7",
	"HOSTNAME8"=>"192.168.1.8"
);
$dbconndata=array(
"192.168.1.210" => "root/pasword",
"192.168.1.211" => "root/pasword",
"192.168.1.212" => "root/pasword",
"192.168.1.213" => "root/pasword",
"192.168.1.214" => "root/pasword",
"192.168.1.215" => "root/pasword",
"192.168.1.216" => "root/pasword",
"192.168.1.217" => "root/pasword"
);

# What we should to do if DB or is not answered - 'stop' or 'dontstop'
$dbfailbehav="dontstop";
*/


$fullpath="/home/a/aromanuq/popwebstudio/public_html/";// Path to site folder
$logfile=$fullpath."project/$projectname/app.log";// Path to site log file
$ap_logfile=$fullpath."project/$projectname/adminpanel.log";// Path to adminpanel log file with 666 permissions
$cron_logfile=$fullpath."project/$projectname/cron.log";// Path to log file for CRON tasks

$companiesprefix=$tableprefix; // Prefix for Companies table
# Mode (debug/any)
$mode="debug";
$serverid="begetquasar";
 ?>