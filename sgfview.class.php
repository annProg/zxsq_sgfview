<?php
/*
 *	sgfview 1.2 by tecbbs.com
 *	2013-7-23
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_zxsq_sgfview {
	function global_header() {
	
		global $_G;
		@extract($_G['cache']['plugin']['zxsq_sgfview']);	//����������ֵ
		if($seletSgfviewer=="1") {
			$script = "<script type=\"text/javascript\" src=\"source/plugin/zxsq_sgfview/tools/sgf/flash_goban.js\"></script>";
		} else {
			$script = "";
		}
		
		//�������ʱ�Ų���ű�
		if(CURMODULE == 'viewthread') {
			return $script;
		}
		return "";
	}
	
	function discuzcode($param) {
		global $_G;
		@extract($_G['cache']['plugin']['zxsq_sgfview']);//����������ֵ
		
		// ���������û�� go �Ļ��򲻳�������ƥ��
		if (strpos($_G['discuzcodemessage'], '[/go]') === false) {
			return false;
		}
		// ���ڽ���discuzcodeʱִ�ж� go �Ľ���
		if($param['caller'] == 'discuzcode') {
			$_G['discuzcodemessage'] = preg_replace('/\s?\[go\][\n\r]*(.+?)[\n\r]*\[\/go\]\s?/ies', '$this->gelgo(\'\\1\')', $_G['discuzcodemessage']);
			
		} else {
			$_G['discuzcodemessage'] = preg_replace('/\s?\[go\][\n\r]*(.+?)[\n\r]*\[\/go\]\s?/ies', '', $_G['discuzcodemessage']);
		}
	}
	function gelgo($sgfcode) {
		global $_G;
		@extract($_G['cache']['plugin']['zxsq_sgfview']);//����������ֵ
		$lang=lang('plugin/zxsq_sgfview');
		
		$sgfcode=str_replace("\n","",$sgfcode);
		$sgfcode=str_replace("\r","",$sgfcode);
		$sgfcode=str_replace("[hr]","[hr ]",$sgfcode);	//[hr]��discuzˮƽ�ߴ����ͻ
		
		$newstr=substr($sgfcode,0,2);

		if($newstr!=="(;" ||(!strpos($sgfcode,"]"))){
			$sgfcode=lang('plugin/zxsq_sgfview','error');
		}
		

		$sgfcode=preg_replace('/\[url(.+?)\](.+?)\[\/url\]/','\\2',$sgfcode);	//���������ʱ�Զ�ת[url]�����sgf�����ĳ�ͻ
		if($seletSgfviewer=="1") {
			if($goWidth <200 || $goHeight<300){
				$goWidth=240;
				$goHeight=450;				//�������̴�С
			}
			if($goHeight/$goWidth < 1.6){
				$goHeight=1.8*$goWidth;			//�������̳��������Ҫ̫����
			}
			include template('zxsq_sgfview:sgf');
			return trim($sgfview);
		} else if($seletSgfviewer=="2") {
			if($goWidth<500) {
				$goWidth=750;
				$goHeight=550;
			}
			$panel=$goWidth/3;	//��˵�����
			
			include template('zxsq_sgfview:flashgoview');
			return trim($flashgoview);
		} else if($seletSgfviewer=="3")
		{
			include template('zxsq_sgfview:goswf');
			return trim($goswf);
		}
			

	}
}

class plugin_zxsq_sgfview_forum extends plugin_zxsq_sgfview {
       function post_editorctrl_left() {  //�������ƾ���ǰ̨ҳ��Ƕ��������
	   	   global $_G;
		   $lang = lang('plugin/zxsq_sgfview'); 
		   @extract($_G['cache']['plugin']['zxsq_sgfview']);//����������ֵ
			if(!in_array($_G['fid'],(array)unserialize($isenable))) return '';
			if($displayBtn) {
		   $btn = "
		   <link rel=\"stylesheet\" href=\"source/plugin/zxsq_sgfview/img/btn_sgf.css\" type=\"text/css\" />
		   <script src=\"source/plugin/zxsq_sgfview/js/addsgf.js\" type=\"text/javascript\"></script>
		   <a id=\"btn_sgf\" title=".lang('plugin/zxsq_sgfview','title')." onClick=\"addsgf('btn_sgf','".lang('plugin/zxsq_sgfview','title')."','".lang('plugin/zxsq_sgfview','l_submit')."','".lang('plugin/zxsq_sgfview','l_close')."','".lang('plugin/zxsq_sgfview','l_tips')."','".lang('plugin/zxsq_sgfview','l_help')."','"."')\" href='javascript:void(0);' >".lang('plugin/zxsq_sgfview','l_sgf')."</a>"; 
		   } else {
				$btn = "";
			}
		   return $btn;
		}
		
}

class plugin_zxsq_sgfview_group extends plugin_zxsq_sgfview_forum {
}

?>