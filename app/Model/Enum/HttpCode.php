<?php
namespace App\Model\Enum;

class HttpCode{
    private static $codesEnum  = [
        '1xx' => 'Informational',
        
        '100' => 'Continue',
        '101' => 'Switching Protocols',
        '102' => 'Processing (WebDAV; RFC 2518)',
        
        '2xx' => 'Success',
            
        '200' => 'OK',
        '201' => 'Created',
        '202' => 'Accepted',
        '204' => 'No Content',
        '206' => 'Partial Content',
        '207' => 'Multi-Status (WebDAV; RFC 4918)',
        '208' => 'Already Reported (WebDAV; RFC 5842)',
        
        '3xx' => 'Redirection',
            
        '300' => 'Multiple Choices',
        '301' => 'Moved Permanently',
        '302' => 'Found',
        '303' => 'See Other',
        '304' => 'Not Modified',
        '307' => 'Temporary Redirect',
        '308' => 'Permanent Redirect (experimental)',
        
        '4xx' => 'Client Error',
            
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '402' => 'Payment Required',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '405' => 'Method Not Allowed',
        '406' => 'Not Acceptable',
        '407' => 'Proxy Authentication Required',
        '408' => 'Request Timeout',
        '409' => 'Conflict',
        '410' => 'Gone',
        '411' => 'Length Required',
        '412' => 'Precondition Failed',
        '413' => 'Payload Too Large',
        '414' => 'URI Too Long',
        '415' => 'Unsupported Media Type',
        '416' => 'Range Not Satisfiable',
        '417' => 'Expectation Failed',
        '418' => "I'm a teapot (RFC 2324)",
        '421' => 'Misdirected Request (RFC 7540)',
        '422' => 'Unprocessable Entity (WebDAV; RFC 4918)',
        '423' => 'Locked (WebDAV; RFC 4918)',
        '424' => 'Failed Dependency (WebDAV; RFC 4918)',
        '426' => 'Upgrade Required',
        '428' => 'Precondition Required',
        '429' => 'Too Many Requests',
        '431' => 'Request Header Fields Too Large',
        '451' => 'Unavailable For Legal Reasons',
        
        '5xx' => 'Server Error',
            
        '500' => 'Internal Server Error',
        '501' => 'Not Implemented',
        '502' => 'Bad Gateway',
        '503' => 'Service Unavailable',
        '504' => 'Gateway Timeout',
        '505' => 'HTTP Version Not Supported',
        '506' => 'Variant Also Negotiates',
        '507' => 'Insufficient Storage (WebDAV; RFC 4918)',
        '508' => 'Loop Detected (WebDAV; RFC 5842)',
        '510' => 'Not Extended',
        '511' => 'Network Authentication Required'
    ];



    public static function getMessage($code){   
        $message = is_string($code) 
            ? HttpCode::$codesEnum[$code]
            : HttpCode::$codesEnum[strval($code)];
        return is_null($message) ? 'Undefined' : $message;
    }

}