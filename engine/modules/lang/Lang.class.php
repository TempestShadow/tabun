<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/
/**
 * Модуль поддержки языковых файлов
 *
 */
class LsLang extends Module {		
	/**
	 * Текущий язык ресурса
	 *
	 * @var string
	 */
	protected $sCurrentLang;
	/**
	 * Язык ресурса, используемый по умолчанию
	 *
	 * @var string
	 */	
	protected $sDefaultLang;
	/**
	 * Путь к языковым файлам
	 *
	 * @var string
	 */	
	protected $sLangPath;
	/**
	 * @var array
	 */
	protected $aLangMsg=array();
	
	/**
	 * Инициализация модуля
	 *
	 * @return null
	 */
	public function Init() {	
		$this->sCurrentLang = Config::Get('lang.current');
		$this->sDefaultLang = Config::Get('lang.default');
		$this->sLangPath = Config::Get('lang.path');
		$this->InitLang();					
	}
	/**
	 * Инициализирует языковой файл
	 *
	 * @return null
	 */
	protected function InitLang() {		
		/**
		 * Если используется кеширование через memcaсhed, то сохраняем данные языкового файла в кеш
		 */
		if (Config::Get('sys.cache.type')=='memory') {			
			if (false === ($this->aLangMsg = $this->Cache_Get("lang_{$this->sCurrentLang}"))) {
				$this->LoadLangFiles($this->sDefaultLang);			
				$this->LoadLangFiles($this->sCurrentLang);
				$this->Cache_Set($this->aLangMsg, "lang_{$this->sCurrentLang}", array(), 60*60);
			}
		} else {
			$this->LoadLangFiles($this->sDefaultLang);
			$this->LoadLangFiles($this->sCurrentLang);
		}	
		/**
		 * Загружаем в шаблон
		 */
		$this->Viewer_Assign('aLang',$this->aLangMsg);
	}
	/**
	 * Загружает текстовки из языковых файлов
	 *
	 * @return null
	 */
	protected function LoadLangFiles($sLangName) {
		$sLangFilePath = $this->sLangPath.'/'.$sLangName.'.php'; 
		if(file_exists($sLangFilePath)) {
			$this->aLangMsg = (count($this->aLangMsg)==0)
				? include($sLangFilePath)
				: array_merge($this->aLangMsg,include($sLangFilePath));				
		}
		/**
		 * Ищет конфиги языковых файлов и объединяет их с текущим
		 */
		$sDirConfig=$this->sLangPath.'/modules/';
		if ($hDirConfig = opendir($sDirConfig)) {
			while (false !== ($sDirModule = readdir($hDirConfig))) {
				if ($sDirModule !='.' and $sDirModule !='..' and is_dir($sDirConfig.$sDirModule)) {
					$sFileConfig=$sDirConfig.$sDirModule.'/'.$sLangName.'.php';
					if (file_exists($sFileConfig)) {
						$aLangModule=include($sFileConfig);						
						$this->aLangMsg=array_merge($this->aLangMsg,$aLangModule);
					}					
				}
			}
			closedir($hDirConfig);
		}
	}
	/**
	 * Установить текущий язык
	 *
	 * @param string $sLang
	 */
	public function SetLang($sLang) {
		$this->sCurrentLang=$sLang;
		$this->InitLang();
	}
	/**
	 * Получить текущий язык
	 *
	 * @return unknown
	 */
	public function GetLang() {
		return $this->sCurrentLang;
	}
	/**
	 * Получить список текстовок
	 *
	 * @return unknown
	 */
	public function GetLangMsg() {
		return $this->aLangMsg;
	}
	/**
	 * Получает текстовку по её имени
	 *
	 * @param  string $sName
	 * @param  array  $aReplace
	 * @return string
	 */
	public function Get($sName,$aReplace=array()) {
		if (isset($this->aLangMsg[$sName])) {
			$sTranslate=$this->aLangMsg[$sName];

			if(is_array($aReplace)&&count($aReplace)) { 
				foreach ($aReplace as $sFrom => $sTo) {
					$aReplacePairs["%%{$sFrom}%%"]=$sTo;
				}
				$sTranslate=strtr($sTranslate,$aReplacePairs);				
			}

			if(Config::Get('module.lang.delete_undefined')) {
				$sTranslate=preg_replace("/\%\%[\S]+\%\%/U",'',$sTranslate);
			}
			return $sTranslate;
		}
		return 'NOT_FOUND_LANG_TEXT';
	}
}
?>