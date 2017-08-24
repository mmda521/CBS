<?php
/*
 *user model 文件
 *
 */
class M_user extends M_common {
	function M_user(){
		parent::__construct();	
	}
	//生成表
function build_table($table = '' ){	
	$sql_table = <<<EOT
CREATE TABLE IF NOT EXISTS `$table` (
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;		
EOT;
	$query = $this->db->query($sql_table);	
}
	

}