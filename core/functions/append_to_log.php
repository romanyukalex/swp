<?php
$log->LogInfo('Got this file');
# $logstr = "text to append to log";

# append_to_log($logstr);

function append_to_log($logstr)
{
        $timestamp = date("M d H:i:s");
        $path = "/path/to/log/";
        $logfile = "filename.log";
        
        $log_append_str = "$timestamp " .$logstr;
        
        if(file_exists($path.$logfile) && is_writeable($path.$logfile))
        {
                $fp = fopen($path.$logfile, 'a+');
                fputs($fp, "$log_append_strrn");
                fclose($fp);
        }
        else if(!file_exists($path.$logfile) && is_writeable($path))
        {
                touch($path.$logfile);
                chmod($path.$logfile, 0600);
                $fp = fopen($path.$logfile, 'a+');
                fputs($fp, "$log_append_strrn");
                fclose($fp);
        }
        else
        {
                die("Unable to write to file..");
        }       
}
?>