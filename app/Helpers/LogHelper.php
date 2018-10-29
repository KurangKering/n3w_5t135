<?php 
namespace App\Helpers;
use Request;
use App\LogActivity as LogActivityModel;
use App\User;
/**
 * LogActivity Helper adalah class untuk mencatat aktivitas user
 * seperti Insert/Update/Delete.
 */
class LogHelper  
{

	public static function dummy()
	{
		echo 'asdasd';
	}
	public static function addToLog($subject)
	{
		$log = [];
		$log['subject'] = $subject;
		$log['nama'] = \Auth::check() ? \Auth::user()->name : 'unknown';
		LogActivityModel::create($log);
	}

	public  static function logActivityLists()
	{
		return LogActivityModel::latest()->get();
	}
	
}