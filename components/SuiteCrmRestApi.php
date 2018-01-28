<?php
/**
 * @copyright ProcessFast, LLC
 * @author Brad Stancel <brad@processfast.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 * @package yii2-suitecrm-rest-api-client
 */

namespace processfast\suitecrm;

use Yii;
use yii\base\Component;
use Asakusuma\SugarWrapper\Rest;

/**
 * SuiteCRM / SugarCRM 6.x REST API Wrapper class available as a Yii2 extension.
 *
 * @author Brad
 */
class SuiteCrmRestApi extends Component {
    
    /**
     * @var array specifies specifies the SuiteCRM/SugarCRM 6.x url - example https://mysuitecrm.com/service/v2/rest.php
     */
    public $rest_url = null;
    
    /**
     * @var string specifies the SuiteCRM/SugarCRM 6.x username
     */
    public $username = null;
    
    /**
     * @var string specifies the SuiteCRM/SugarCRM 6.x username
     */
    public $password = null;
    
    /**
     * An instance of a Asakusuma\SugarWrapper\Rest.
     *
     * @var Asakusuma\SugarWrapper\Rest
     */
    private $sugarWrapperRest;
    
    
    
    /**
     * Constructor called on the creation of an instance of this class.
     * 
     * @return Asakusuma\SugarWrapper\Rest SugarCRM Rest API class
     */
    public function __construct() {
        
        $this->sugarWrapperRest = new Asakusuma\SugarWrapper\Rest;
        $this->sugarWrapperRest = $this->sugarWrapperRest->setUrl($this->rest_url);
        $this->sugarWrapperRest = $this->sugarWrapperRest->setUsername($this->username);
        $this->sugarWrapperRest = $this->sugarWrapperRest->setPassword($this->password);
           
        return $this->sugarWrapperRest;
    }
    
    

    

}
