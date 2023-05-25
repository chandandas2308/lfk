<?php

namespace OneWaySMS;
use OneWaySMS\SmsHistory;

class SMS
{
    private static $username;
    private static $sender_id;
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

    protected static $transaction_codes = [
        '0' => 'SMS received on mobile handset',
        '100' => 'Message delivered to Telco',
        '-100' => 'MTID invalid / not found',
        '-200' => 'SMS failed to send',
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

	private function __construct () { }

    public static function to($var){
        static::$mobile_number = $var;
        return new static;
    }

    public static function message($var){
        static::$message = $var;
        return new static;
    }

    public static function checkCredential() {
        if (!static::$username || !static::$password) {
            static::$username = getenv('ONEWAY_USERNAME');
            static::$password = getenv('ONEWAY_PASSWORD');
        }
    }

    public static function send(){
        self::checkCredential();

    	$url = "http://gateway.onewaysms.com.my:10001/";
        $url .= "api.aspx?apiusername=".static::$username."&apipassword=".static::$password;
        $url .= "&senderid=".rawurlencode('1');
        $url .= "&mobileno=".rawurlencode(static::$mobile_number);
        $url .= "&message=".rawurlencode(stripslashes(static::$message)) . "&languagetype=1";
        $result = implode ('', file ($url));

        if (isset(static::$error_codes[$result])) {
            $mtid = NULL;
            $response_code = $result;
        } else {
            $mtid = $result;
            $response_code = $result;
            // @Todo: update response code (queue?)
        }

        $sms = SmsHistory::create([
            'message' => static::$message,
            'mobile_number' => static::$mobile_number,
            'mtid' => $mtid,
            'response_code' => $result,
        ]);

        return [
            'message'   => isset(static::$error_codes[$result]) ? static::$error_codes[$result] : $result,
        ];
    }

    public static function status($mt_id) {
        $url = "http://gateway.onewaysms.com.my:10001/";
        $url .= "bulktrx.aspx";
        $url .= "?mtid=".rawurlencode($mt_id);
        $result = implode ('', file ($url));

        return static::$transaction_codes[$result];
    }
}
