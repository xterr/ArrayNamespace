<?php
/**
 * Class ArrayNamespace
 */

class ArrayNamespace
{
	protected $_aData = [];

	public function get($sKey)
	{
		$aData  = $this->_aData;
		$aParts = explode('.', $sKey);
		$mValue = NULL;

		while (count($aParts) > 0)
		{
			$sKey  = array_shift($aParts);

			if (!isset($aData[$sKey]))
			{
				return NULL;
			}

			$mValue = $aData[$sKey];
			$aData  = $mValue;
		}

		return $mValue;
	}

	public function increment($sKey, $nValue)
	{
		$this->_initKey($sKey);

		$mPrevValue = (int) $this->get($sKey);
		$sString    = $this->_getNamespace($sKey) . ' = ' . ($nValue + $mPrevValue) . ';';
		eval($sString);
	}

	public function set($sKey, $mValue)
	{
		$this->_initKey($sKey);

		if (is_array($mValue))
		{
			$sString = $this->_getNamespace($sKey) . " = \$mValue;";
		}
		else if (!is_numeric($mValue) && is_string($mValue))
		{
			$mValue = '"' . str_replace('"', '\\"', $mValue) . '"';
			$sString = $this->_getNamespace($sKey) . " = " . $mValue . ";";
		}
		else
		{
			$sString = $this->_getNamespace($sKey) . " = " . $mValue . ";";
		}

		eval($sString);
	}

	public function sort($sKey, $sField, $bDesc = TRUE)
	{
		$aData = $this->get($sKey);
		self::cmp($aData, $sField, $bDesc);

		$this->set($sKey, $aData);
	}

	public function toArray()
	{
		return $this->_aData;
	}

	protected function _getNamespace($sKey)
	{
		$aParts  = explode('.', $sKey);
		$sString = "\$this->_aData";

		while (count($aParts) > 0)
		{
			$sKey     = array_shift($aParts);
			$sString .= "['{$sKey}']";
		}

		return $sString;
	}

	protected function _initKey($sKey)
	{
		$aTmp   = [];
		$aParts = explode('.', $sKey);

		while (count($aParts) > 0)
		{
			$sKey = array_pop($aParts);
			$aTmp = [$sKey => $aTmp];
		}

		$this->_aData = $this->_aData + $aTmp;
	}

	public static function cmp(&$aData = NULL, $sField, $bDesc = TRUE)
	{
		return uasort($aData, self::_buildSorter($sField, $bDesc));
	}

	protected static function _buildSorter($sField, $bDesc)
	{
		return function ($a, $b) use ($sField, $bDesc) {
			return ($a[$sField] - $b[$sField]) * ($bDesc ? -1 : 1);
		};
	}
}
