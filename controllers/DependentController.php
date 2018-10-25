<?php    
namespace app\controllers;
use yii\helpers\Html;

use Yii;

class DependentController extends \yii\web\Controller
{
    public function actionGetsubgroup($id)
    {
        $rows = NewGroup::find()->where(['IdDepartamento' => $id])
        ->all(); 
        echo "<option value=''>---Select State---</option>";     
        if(count($rows)>0){
            foreach($rows as $row){
                echo "<option value='$row->IdMunicipios'>$row->DescripcionMunicipios</option>";
            }
        }
        else{
            echo "";
        } 
    }
}