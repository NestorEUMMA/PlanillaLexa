<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //}'css/site.css',
        'assets/css/bootstrap.min.css',
        'assets/css/material-dashboard.css?v=1.2.1',
        'assets/css/demo.css',
        'assets/css/font-awesome.min.css',
        'assets/css/material-icons.css',
        'assets/css/family-material-icons.css',
         'http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
        // 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons',
        // 'https://fonts.googleapis.com/icon?family=Material+Icons',


    ];
    public $js = [
        'assets/js/bootstrap.min.js',
        'assets/js/material.min.js',
        'assets/js/perfect-scrollbar.jquery.min.js',
        'assets/js/arrive.min.js',
        'assets/js/jquery.validate.min.js',
        'assets/js/moment.js',
        'assets/js/fullcalendar.js',
        'assets/js/jquery-ui.min.js',
        'assets/js/chartist.min.js',
        'assets/js/jquery.bootstrap-wizard.js',
        'assets/js/bootstrap-notify.js',
        'assets/js/bootstrap-datetimepicker.js',
        'assets/js/jquery-jvectormap.js',
        'assets/js/nouislider.min.js',
        'assets/js/jquery.select-bootstrap.js',
        'assets/js/jquery.datatables.js',
        'assets/js/sweetalert2.js',
        'assets/js/es.js',
        'assets/js/jquery.tagsinput.js',
        'assets/js/material-dashboard.js?v=1.2.1',
        'assets/js/demo.js',
        'assets/js/jquery.maskMoney.min.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
