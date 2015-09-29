<?php
namespace Souii\Site;
use Souii\Models\Systems as Systems;
use Phalcon\Mvc\User\Component;
use Souii\Redis\RedisUtils as RedisUtils;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Component
{

    private $_headerMenu = array(
        'navbar-left' => array(
            'index' => array(
                'caption' => 'Home',
                'action' => 'index'
            ),
            'invoices' => array(
                'caption' => 'Invoices',
                'action' => 'index'
            ),
            'about' => array(
                'caption' => 'About',
                'action' => 'index'
            ),
            'contact' => array(
                'caption' => 'Contact',
                'action' => 'index'
            ),
        ),
        'navbar-right' => array(
            'session' => array(
                'caption' => 'Log In/Sign Up',
                'action' => 'index'
            ),
        )
    );

    private $_tabs = array(
        '我的博客' => array(
            'controller' => 'manager',
            'action' => 'index',
            'iconClass'=>'glyphicon glyphicon-book',
            'any' => true
        ),
        '系统设置' => array(
            'controller' => 'systems',
            'action' => 'search',
            'iconClass'=>'glyphicon glyphicon-pencil',
            'any' => true
        ),
    );

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu()
    {

        $auth = $this->session->get('auth');
        if ($auth) {
            $this->_headerMenu['navbar-right']['session'] = array(
                'caption' => 'Log Out',
                'action' => 'end'
            );
        } else {
            unset($this->_headerMenu['navbar-left']['invoices']);
        }

        $controllerName = $this->view->getControllerName();
        foreach ($this->_headerMenu as $position => $menu) {
            echo '<div class="nav-collapse">';
            echo '<ul class="nav navbar-nav ', $position, '">';
            foreach ($menu as $controller => $option) {
                if ($controllerName == $controller) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($controller . '/' . $option['action'], $option['caption']);
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }

    }

    /**
     * Returns menu tabs
     */
    public function getTabs()
    {
        $controllerName = $this->view->getControllerName();
        $actionName = $this->view->getActionName();
        echo '<ul class="nav nav-sidebar">';
        foreach ($this->_tabs as $caption => $option) {
            if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            echo  '<a href="/'.$option['controller'] . '/' . $option['action'].'"><span class="'.$option['iconClass'].'" aria-hidden="true"></span>'.$caption. '</a></li>';
        }
        echo '</ul>';
    }

    public function getSysVar($key){
        return $this->redisUtils->getCache(RedisUtils::$CACHEKEYS['SYSTEMS']['KEY'],'Souii\Site\Elements::getSysVarCall',$key);
    }

    public static function getSysVarCall($key){
        $conf = Systems::findFirst(array(
            "system_name = :system_name:",
            'bind'=>array(
                'system_name'=>$key
            )
        ));
        if(isset($conf->system_value)){
            return $conf->system_value;
        }else{
            return '';
        }
    }
}
