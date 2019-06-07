<?php
  /***************************************************************
  * Snippet Name : password_complexity		 					 *
  * Scripted By  : RomanyukAlex		           					 *
  * Website      : http://popwebstudio.ru	   					 *
  * Email        : admin@popwebstudio.ru     					 *
  * License      : GPL (General Public License)					 *
  * Purpose 	 : Password generator and validator module		 *
  * Access		 : insert_module("password_complexity");	 	 *
  *				Generate: $Password = new Password("");			 *
  *					echo $Password->getPassword();				 *
  *				Check: $Password = new Password($Secret);		 *
  *					if (!$Password->isValid()) {'not secure'}	 *
  ***************************************************************/
  
/*****************************************************************
 * [PASSWORD_COMPLEXITY]
 *****************************************************************
 * Password generator and validator module
 *
 * $MinTotalChars (@int): The minimum number of characters a password must have
 * $MaxTotalChars (@int): The maximum number of characters a password must have
 * $MinUpperChars (@int): The miminum number of upper-cased characters ([A-Z]) a password must have
 * $MinLowerChars (@int): The minimum number of lower-cased characters ([a-z]) a password must have
 * $MinNumericChars (@int): The minimum number of numeric characters ([0-9]) a password must have
 * $MinSpecialChars (@int): The minimum number of special characters (-=;'\,.~!@#$%^&*()_+{}:|<>?) a password must have
 * $MaxConsecutiveChars (@int): The maximum number of consecutive characters (abc, 123, DeF) a password must have (we'll consider consecutive
 * the characters that have consecutive ASCII codes (789:;<=>?@ABC are consecutive)
 * BlockSpecialWords (@bool): The term of "special words" reffer to words such as username, customer name, TN. Can be "Y" or "N"
 ******************************************************************/
 
class Password
{

    private $_MinTotalChars;

    private $_MaxTotalChars;

    private $_MinUpperChars;

    private $_MinLowerChars;

    private $_MinNumericChars;

    private $_MinSpecialChars;

    private $_MaxConsecutiveChars;

    private $_BlockSpecialWords;

    private $_AccountTypes;

    private $_AllowedAccountTypes;

    protected $_Password;

    protected $_SpecialCharsRegEx = "/[-=;'\,.~!@#\$%^&*()_+{}:|<>?]/";

    protected $_UpperCaseCharsRegEx = "/[A-Z]/";

    protected $_LowerCaseCharsRegEx = "/[a-z]/";

    protected $_NumericCharsRegEx = "/[0-9]/";

    protected $_SpecialCharsString = "-=;'\,.~!@#\$%^&*()_+{}:|<>?";

    protected $_UpperCaseCharsString = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    protected $_LowerCaseCharsString = "abcdefghijklmnopqrstuvwxyz";

    protected $_NumericCharsString = "0123456789";

    final public function __construct($Password = "", $EnvironmentParams = array(), $ConfigParams = array())
    {
        global $_CONFIG;
		echo $_CONFIG['MinTotalChars'];
		global $MinTotalChars,$MaxTotalChars,$MinUpperChars,$MinLowerChars,$MinNumericChars,$MinSpecialChars,$MaxConsecutiveChars,$BlockSpecialWords,$AccountTypes,$userrole,$username;
		
		$_CONFIG['MinTotalChars']=$MinTotalChars;
		$_CONFIG['MaxTotalChars']=$MaxTotalChars;
		$_CONFIG['MinUpperChars']=$MinUpperChars;
		$_CONFIG['MinLowerChars']=$MinLowerChars;
		$_CONFIG['MinNumericChars']=$MinNumericChars;
		$_CONFIG['MinSpecialChars']=$MinSpecialChars;
		$_CONFIG['MaxConsecutiveChars']=$MaxConsecutiveChars;
		$_CONFIG['BlockSpecialWords']=$BlockSpecialWords;

        
		//initializing the object properties
        $this->_MinTotalChars = isset($ConfigParams['MinTotalChars']) ? $ConfigParams['MinTotalChars'] : $_CONFIG['MinTotalChars'];
        $this->_MaxTotalChars = isset($ConfigParams['MaxTotalChars']) ? $ConfigParams['MaxTotalChars'] : $_CONFIG['MaxTotalChars'];
        $this->_MinUpperChars = isset($ConfigParams['MinUpperChars']) ? $ConfigParams['MinUpperChars'] : $_CONFIG['MinUpperChars'];
        $this->_MinLowerChars = isset($ConfigParams['MinLowerChars']) ? $ConfigParams['MinLowerChars'] : $_CONFIG['MinLowerChars'];
        $this->_MinNumericChars = isset($ConfigParams['MinNumericChars']) ? $ConfigParams['MinNumericChars'] : $_CONFIG['MinNumericChars'];
        $this->_MinSpecialChars = isset($ConfigParams['MinSpecialChars']) ? $ConfigParams['MinSpecialChars'] : $_CONFIG['MinSpecialChars'];
        $this->_MaxConsecutiveChars = isset($ConfigParams['MaxConsecutiveChars']) ? $ConfigParams['MaxConsecutiveChars'] : $_CONFIG['MaxConsecutiveChars'];
        $this->_BlockSpecialWords = isset($ConfigParams['BlockSpecialWords']) ? $ConfigParams['BlockSpecialWords'] : $_CONFIG['BlockSpecialWords'];
        $this->_AccountTypes = isset($ConfigParams['AccountTypes']) ? $ConfigParams['AccountTypes'] : $_CONFIG['AccountTypes'];
        /*
        $this->_AccountLevel = isset($EnvironmentParams['AccountLevel']) ? $EnvironmentParams['AccountLevel'] : "";
        $this->_UserName = isset($EnvironmentParams['UserName']) ? $EnvironmentParams['UserName'] : "";
        $this->_CustomerName = isset($EnvironmentParams['CustomerName']) ? $EnvironmentParams['CustomerName'] : "";
        $this->_PhoneNumber = isset($EnvironmentParams['PhoneNumber']) ? $EnvironmentParams['PhoneNumber'] : "";
        */
                
        //verify the input data
        if ($this->_MinTotalChars > $this->_MaxTotalChars || $this->_MaxTotalChars < ($this->_MinUpperChars + $this->_MinLowerChars + $this->_MinNumericChars + $this->_MinSpecialChars)) {
            return false;
        }
        
        if ($Password != "") {
            $this->_Password = $Password;
        } else {
            do {
                $this->_generatePassword();
            } while (!$this->isValid());
			
        }
    }
	public function getparam(){
		return $_CONFIG['MinTotalChars'];
	}

    private function _validTotalChars()
    {
        return strlen($this->_Password) >= $this->_MinTotalChars && strlen($this->_Password) <= $this->_MaxTotalChars;
    }

    private function _validUpperChars()
    {
        $i = 0;
        $UpperCharsNum = 0;
        $validated = false;
        $PasswordLength = strlen($this->_Password);
        while (!$validated && $i < $PasswordLength) {
            if (preg_match($this->_UpperCaseCharsRegEx, $this->_Password[$i])) {
                $UpperCharsNum++;
                if ($UpperCharsNum == $this->_MinUpperChars) {
                    $validated = true;
                }
            }
            $i++;
        }
        
        return $UpperCharsNum >= $this->_MinUpperChars;
    }

    private function _validLowerChars()
    {
        $i = 0;
        $LowerCharsNum = 0;
        $validated = false;
        $PasswordLength = strlen($this->_Password);
        while (!$validated && $i < $PasswordLength) {
            if (preg_match($this->_LowerCaseCharsRegEx, $this->_Password[$i])) {
                $LowerCharsNum++;
                if ($LowerCharsNum == $this->_MinLowerChars) {
                    $validated = true;
                }
            }
            $i++;
        }
        
        return $LowerCharsNum >= $this->_MinLowerChars;
    }

    private function _validNumericChars()
    {
        $i = 0;
        $NumericCharsNum = 0;
        $validated = false;
        $PasswordLength = strlen($this->_Password);
        while (!$validated && $i < $PasswordLength) {
            if (preg_match($this->_NumericCharsRegEx, $this->_Password[$i])) {
                $NumericCharsNum++;
                if ($NumericCharsNum == $this->_MinNumericChars) {
                    $validated = true;
                }
            }
            $i++;
        }
        
        return $NumericCharsNum >= $this->_MinNumericChars;
    }

    private function _validSpecialChars()
    {
        $i = 0;
        $SpecialCharsNum = 0;
        $validated = false;
        $PasswordLength = strlen($this->_Password);
        while (!$validated && $i < $PasswordLength) {
            if (preg_match($this->_SpecialCharsRegEx, $this->_Password[$i])) {
                $SpecialCharsNum++;
                if ($SpecialCharsNum == $this->_MinSpecialChars) {
                    $validated = true;
                }
            }
            $i++;
        }
        
        return $SpecialCharsNum >= $this->_MinSpecialChars;
    }

    private function _validConsecutiveChars($IgnoreCase = true)
    {
        $chars = str_split($this->_Password);
        $chars = array_unique($chars);
        
        $isValid = true;
        
        foreach ($chars as $char) {
            $invalid_sequence = str_repeat($char, $this->_MaxConsecutiveChars + 1);
            
            if ($IgnoreCase) {
                if (false !== strpos(strtolower($this->_Password), strtolower($invalid_sequence))) {
                    $isValid = false;
                }
            } else {
                if (false !== strpos($this->_Password, $invalid_sequence)) {
                    $isValid = false;
                }
            }
        
        }
        
        return $isValid;
    }

    private function _validSpecialWords()
    {
        if ("N" == $this->_BlockSpecialWords || ("" == $this->_UserName && "" == $this->_CustomerName && "" == $this->_PhoneNumber)) {
            return true;
        }
        
        /** NOTE: DO NOT CHANGE! */
        if (strlen($this->_UserName) && 0 !== preg_match("/{$this->_UserName}/i", $this->_Password)) {
            return false;
        }
        
        if (strlen($this->_PhoneNumber) && 0 !== preg_match("/{$this->_PhoneNumber}/", $this->_Password)) {
            return false;
        }
        
        if (strlen($this->_CustomerName) && 0 !== preg_match("/{$this->_CustomerName}/i", $this->_Password)) {
            return false;
        }
        
        $CustomerName = explode(" ", $this->_CustomerName);
        $CustomerNameLength = count($CustomerName);
        for ($i = 0; $i < $CustomerNameLength; $i++) {
            if (strlen($CustomerName[$i]) && 0 !== preg_match("/" . $CustomerName[$i] . "/i", $this->_Password)) {
                return false;
            }
        }
        
        return true;
    }

    public function _generatePassword()
    {
        $BasicPassword = str_shuffle(substr(str_shuffle($this->_SpecialCharsString), 0, $this->_MinSpecialChars) . substr(str_shuffle($this->_UpperCaseCharsString), 0, $this->_MinUpperChars) . substr(str_shuffle($this->_LowerCaseCharsString), 0, $this->_MinLowerChars) . substr(str_shuffle($this->_NumericCharsString), 0, $this->_MinNumericChars));
        $BasicPasswordLength = strlen($BasicPassword);
        $MinOffsetChars = ($this->_MinTotalChars - $BasicPasswordLength) < 0 ? 0 : $this->_MinTotalChars - $BasicPasswordLength;
        $OffsetChars = mt_rand($MinOffsetChars, $this->_MaxTotalChars - $BasicPasswordLength);
        $this->_Password = $BasicPassword . substr(str_shuffle($this->_SpecialCharsString . $this->_UpperCaseCharsString . $this->_LowerCaseCharsString . $this->_NumericCharsString), 0, $OffsetChars);
    }

    public function isValid()
    {        
        return $this->_validTotalChars() && $this->_validUpperChars() && $this->_validLowerChars() && $this->_validNumericChars() && $this->_validSpecialChars() && $this->_validConsecutiveChars() && $this->_validSpecialWords();
    }

    public function debug()
    {
        var_dump($this->_validTotalChars(), $this->_validUpperChars(), $this->_validLowerChars(), $this->_validNumericChars(), $this->_validSpecialChars(), $this->_validConsecutiveChars(), $this->_validSpecialWords());
    }

    public function getPassword()
    {
        return $this->_Password;
    }
}

/*EOF*/