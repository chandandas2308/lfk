<?php
namespace OneWaySMS;
class Account
{
	private static $username;
	private static $password;
	private static $mobile_number;
	private static $message;
	private static $_instance = null;

	protected static $error_codes = [
        '-100' => 'apipassname or apipassword is invalid',
        '-200' => 'senderid parameter is invalid',
        '-300' => 'mobile parameter is invalid',
        '-400' => 'languagetype is invalid',
        '-500' => 'Invalid characters in message',
        '-600' => 'Insufficient credit balance'
    ];

	public static function make(array $details = [])
    {
    	static::$username = $details['username'];
    	static::$password = $details['password'];
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

	public function __construct() { }

    public static function checkCredential() {
        if (!static::$username || !static::$password) {
            static::$username = getenv('ONEWAY_USERNAME');
            static::$password = getenv('ONEWAY_PASSWORD');
        }
    }

    public static function balance() {
        self::checkCredential();
    	$query_string = "bulkcredit.aspx?apiusername=".static::$username."&apipassword=".static::$password;
        $url = "http://gateway.onewaysms.com.my:10001/".$query_string;
        $response = implode ('', file ($url));
        if (isset(static::$error_codes[$response])) {
            return static::$error_codes[$response];
        } else {
            return $response;
        }
    }
}
