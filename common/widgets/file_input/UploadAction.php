<?php
namespace common\widgets\file_input;
 
use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use common\widgets\file_input\Uploader;

class UploadAction extends Action
{
    /**
     * 配置文件
     * @var array
     */
    public $config = [];
    
    public function init()
    {
        //close csrf
        Yii::$app->request->enableCsrfValidation = false;
        
        //默认设置
        $_config = require(__DIR__ . '/config.php');
        //load config file
        $this->config = ArrayHelper::merge($_config, $this->config);
        parent::init();
    }
    
    public function run()
    {
        $action = Yii::$app->request->get('action');
        switch ($action) {
            case 'uploadimage': /* 上传图片 */ 
            case 'uploadfile':  /* 上传文件 */
            	$this->config['formName'] = getArrayFirstKey($_FILES);
            	$this->config['fieldName'] = getArrayFirstKey($_FILES[$this->config['formName']]['name']);
                $result = $this->ActUpload();
                break;
            case 'deleteimage': /* 删除图片 */
            case 'deletefile':  /* 删除文件 */
            	$result = $this->ActDelete();
            	break;
            default:
                $result = json_encode(array(
                    'state' => '请求地址出错'
                ));
                break;
        }
        echo json_encode($result);
    }
    
    /**
     * 上传
     * @return string
     */
    protected function ActUpload()
    {
        switch (htmlspecialchars($_GET['action'])) {
            
            case 'uploadimage':
                $config = array(
                    "pathFormat" => $this->config['imagePathFormat'],
                    "maxSize" => $this->config['imageMaxSize'],
                    "allowFiles" => $this->config['imageAllowFiles'],
                    "fieldName" => $this->config['fieldName'],
                    "formName" => $this->config['formName'],
                );
                break;
                
            case 'uploadfile':
            default:
                $config = array(
                    "pathFormat" => $this->config['filePathFormat'],
                    "maxSize" => $this->config['fileMaxSize'],
                    "allowFiles" => $this->config['fileAllowFiles'],
                    "fieldName" => $this->config['fieldName'],
                    "formName" => $this->config['formName'],
                );
                break;
        }
        $config['uploadFilePath'] = isset($this->config['uploadFilePath'])?$this->config['uploadFilePath']:'';
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($config);
        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
        */
        /* 返回数据 */
        return $up->getFileInfo();
    }
    
    /**
     * 删除
     * @return string
     */
    protected function ActDelete()
    {    	
    	return Yii::$app->request->post();
    }
}