<?php
namespace Souii\Controllers;
use Phalcon\Mvc\View;
use Souii\Models;
use Phalcon\Mvc\Controller;
use Souii\Responses\JSONResponse as JSONResponse;

class JsonControllerBase extends Base
{
    //定义调用webService接口
    protected $curlRest;

    public function initialize()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }


    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1]
            )
        );
    }

    public function afterExecuteRoute($dispatcher)
    {
        if($this->request->isAjax()){
            $records = $dispatcher->getReturnedValue();
            $error = false;
            !isset($records->error)||$error=$records->error;
            $response =new JSONResponse();
            $response->useEnvelope(true)
                ->convertSnakeCase(false)
                ->send($records,$error);
            return;
        }
    }




    /**
     * @param $array request请求保存数据的数组
     * @param $fileName 文件名数组
     * @param $required 是否必填文件
     * @return bool|string
     */
    public function   cutPic(&$psotArray, $fileName, $required = true)
    {
        $array = array();
        $uploadedFileName = true;
        $array['x'] = $this->request->getPost('x', null, 0);
        $array['y'] = $this->request->getPost('y', null, 0);
        $array['w'] = $this->request->getPost('w', null, 150);
        $array['h'] = $this->request->getPost('h', null, 150);
        $array['jpeg_quality'] = $this->request->getPost('jpeg_quality', null, 100);
        $array['targ_w'] = $this->request->getPost('targ_w', null, $array['w']);
        $array['targ_h'] = $this->request->getPost('targ_h', null, $array['h']);
        if ($_FILES && array_key_exists($fileName, $_FILES)) {
            $array['src'] = $_FILES[$fileName]["tmp_name"];
            $img_r = null;
            switch ($_FILES[$fileName]['type']) {
                case 'image/jpg':
                case 'image/jpeg':
                case 'image/pjpeg':
                    $img_r = imagecreatefromjpeg($array['src']);
                    break;
                case 'image/png':
                    $img_r = imagecreatefrompng($array['src']);
                    imagesavealpha($img_r, true);
                    break;
                default:
                    return false;
            }

            $dst_r = ImageCreateTrueColor($array['targ_w'], $array['targ_h']);
            // $img = imagecreatefrompng($src);
            // imagesavealpha($img,true);//这里很重要;
            // $thumb = imagecreatetruecolor(300,300);
            // imagealphablending($thumb,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
            // imagesavealpha($thumb,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
            // imagecopyresampled($thumb,$img,0,0,0,0,300,300,300,300);
            // imagepng($thumb,"temp.png");

           if($_FILES[$fileName]['type']=='image/png') {
                    imagealphablending($dst_r, false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
                    imagesavealpha($dst_r, true);//这里很重要,意思是不要丢了$thumb图像的透明色;
            }

            imagecopyresampled($dst_r, $img_r, 0, 0, $array['x'], $array['y'],
                $array['targ_w'], $array['targ_h'], $array['w'], $array['h']);

            switch ($_FILES[$fileName]['type']) {
                case 'image/jpg':
                case 'image/jpeg':
                case 'image/pjpeg':
                    imagejpeg($dst_r, $array['src'], $array['jpeg_quality']);
                    break;
                case 'image/png':
                    imagepng($dst_r, $array['src'], 0);
                    break;
                default:
                    return false;
            }
            $ret1 = $this->curlFileRest->performPostRequest("/v1/tfs", file_get_contents($array['src']));
            $psotArray[$fileName] = json_decode($ret1)->TFS_FILE_NAME;
            $uploadedFileName = $psotArray[$fileName];
        } elseif ($required) {
            return false;
        }
        return $uploadedFileName;
    }

    /**
     * @param $array request请求保存数据的数组
     * @param $fileArray 文件名数组
     * @param $required 是否必填文件
     * @return array|bool
     */
    public function uploadFile(&$psotArray, $fileNameArray, $required = true)
    {
        if (!is_array($fileNameArray)) {
            $fileNameArray = array(
                $fileNameArray
            );
        }
        $uploadedFileNames = array();
        foreach ($fileNameArray as $fileName) {
            if ($_FILES && array_key_exists($fileName, $_FILES)) {
                $ret1 = $this->curlFileRest->performPostRequest("/v1/tfs", file_get_contents($_FILES[$fileName]["tmp_name"]));
                $psotArray[$fileName] = json_decode($ret1)->TFS_FILE_NAME;
                //记录已经上传了这个文件
                $uploadedFileNames[] = $psotArray[$fileName];
            } elseif ($required) {
                //出现必填但是没有图片的情况，全部回退。
                foreach ($uploadedFileNames as $uploadedFileName) {
                    $this->curlFileRest->performDeleteRequest('/v1/tfs/' . $uploadedFileName, null);
                }
                return false;
            }
        }
        return $uploadedFileNames;
    }

    /**
     * @param $array request请求保存数据的数组
     * @param $fileArray 文件名数组
     * @param $data 提交结果返回数据
     * @return array
     */
    public function deleteFile(&$psotArray, $fileNameArray, $data)
    {
        if (!is_array($fileNameArray)) {
            $fileNameArray = array(
                $fileNameArray
            );
        }
        $deletedFileNames = array();
        foreach ($fileNameArray as $fileName) {
            if ($_FILES && array_key_exists($fileName, $_FILES) &&array_key_exists($fileName, $psotArray) && json_decode($data)->zhuangTaiMa < 0) {
                $this->curlFileRest->performDeleteRequest('/v1/tfs/' . $psotArray[$fileName], null);
                $deletedFileNames[] = $fileName;
            }
        }
        return $deletedFileNames;
    }

    /**
     * 快速构建Post数据
     */
    public function getPostData(&$array,$keyArray){
        foreach($keyArray as $key){
            $array[$key] = $this->request->getPost($key);
        }
    }
    /**
     * 快速构建Put数据
     */
    public function getPutData(&$array,$keyArray){
        foreach($keyArray as $key){
            $array[$key] = $this->request->getPut($key);
        }
    }

}