<?php

function dump($data) {
    if(is_array($data)) { //If the given variable is an array, print using the print_r function.
        print "<pre>-----------------------\n";
        print_r($data);
        print "-----------------------</pre>";
    } elseif (is_object($data)) {
        print "<pre>==========================\n";
        var_dump($data);
        print "===========================</pre>";
    } else {
        print "=========&gt; ";
        var_dump($data);
        print " &lt;=========";
    }
} 

class fileInit {
	/**
	*�������ļ�
	*@param  string  $filename  ��Ҫ�������ļ�
	*  @return 
	*/
	public function create_file($filename) {
	   if (file_exists($filename)) return false;
	   $this->create_dir(dirname($filename)); //����Ŀ¼
	   return @file_put_contents($filename,'');
	}

	/**
	*д�ļ�
	*@param  string  $filename  �ļ�����
	*@param  string  $content   д���ļ�������
	*@param  string  $type ���ͣ�1=����ļ����ݣ�д�������ݣ�2=�����ݺ����������
	*  @return 
	*/
	  public function write_file($filename, $content, $type = 1) {
	  if ($type == 1) {
	  if (file_exists($filename)) $this->del_file($filename); //ɾ���ļ�
	  $this->create_file($filename);
	  return $this->write_file($filename, $content, 2);
	   } else {
	  if (!is_writable($filename)) return false;
	  $handle = @fopen($filename, 'a');
	  if (!$handle) return false;
	  $result = @fwrite($handle, $content);
	  if (!$result) return false;
	  @fclose($handle);
	  return true;
	   }
	}

	/**
	*����һ�����ļ�
	*@param  string  $filename�ļ�����
	*@param  string  $newfilename ���ļ�����
	*  @return 
	*/
	public function copy_file($filename, $newfilename) {
	   if (!file_exists($filename) || !is_writable($filename)) return false;
	   $this->create_dir(dirname($newfilename)); //����Ŀ¼
	   return @copy($filename, $newfilename);
	}

	/**
	*�ƶ��ļ�
	*@param  string  $filename�ļ�����
	*@param  string  $newfilename ���ļ�����
	*  @return 
	*/
	public function move_file($filename, $newfilename) {
	   if (!file_exists($filename) || !is_writable($filename)) return false;
	   $this->create_dir(dirname($newfilename)); //����Ŀ¼
	   return @rename($filename, $newfilename);
	}

	/**
	*ɾ���ļ�
	*@param  string  $filename  �ļ�����
	*  @return bool
	*/
	public function del_file($filename) {
	   if (!file_exists($filename) || !is_writable($filename)) return true;
	   return @unlink($filename);
	}

	/**
	*��ȡ�ļ���Ϣ
	*@param  string  $filename  �ļ�����
	*  @return array('�ϴη���ʱ��','inode �޸�ʱ��','ȡ���ļ��޸�ʱ��','��С'��'����')
	*/
	public function get_file_info($filename) {
	   if (!file_exists($filename)) return false;
	   return array(
	  'atime' => date("Y-m-d H:i:s", fileatime($filename)),
	  'ctime' => date("Y-m-d H:i:s", filectime($filename)),
	  'mtime' => date("Y-m-d H:i:s", filemtime($filename)),
	  'size'  => filesize($filename),
	  'type'  => filetype($filename)
	   );
	}

	/**
	*����Ŀ¼
	*@param  string  $path   Ŀ¼
	*  @return 
	*/
	public function create_dir($path) {
	   if (is_dir($path)) return false;
	   fileInit::create_dir(dirname($path));
	   @mkdir($path);
	   @chmod($path, 0777);
	   return true;
	}

	/**
	*ɾ��Ŀ¼
	*@param  string  $path   Ŀ¼
	*  @return 
	*/
	public function del_dir($path) {
	   $succeed = true;
	   if(file_exists($path)){
	  $objDir = opendir($path);
	  while(false !== ($fileName = readdir($objDir))){
	 if(($fileName != '.') && ($fileName != '..')){
	chmod("$path/$fileName", 0777);
	if(!is_dir("$path/$fileName")){
	if(!@unlink("$path/$fileName")){
	   $succeed = false;
	   break;
	}
	}
	else{
	self::del_dir("$path/$fileName");
	}
	 }
	  }
	  if(!readdir($objDir)){
	 @closedir($objDir);
	 if(!@rmdir($path)){
	$succeed = false;
	 }
	  }
	   }
	   return $succeed;
	}
	}


	function is_date($date){
		if($date == date('Y-m-d',strtotime($date))){
			return true;
		}else{
			return false;
		}
	}