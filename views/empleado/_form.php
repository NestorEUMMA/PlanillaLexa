 <?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Tipodocumento;
use app\models\Institucionprevisional;
use app\models\Tipoempleado;
use app\models\Estadocivil;
use app\models\Puestoempresa;
use app\models\Empleado;
use app\models\Departamentos;
use app\models\Departamentoempresa;
use app\models\Municipios;
use app\models\Banco;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\money\MaskMoney;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Empleado */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empleado-form box panel solid">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                        <div class="row">
                        <div class="col-sm-12 ">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Ingreso de Empleado
                                        <small></small>
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <ul class="nav nav-pills nav-pills-warning">
                                        <li class="active">
                                            <a href="#pill1" data-toggle="tab">Datos Laborales</a>
                                        </li>
                                        <li>
                                            <a href="#pill2" data-toggle="tab">Datos Personales</a>
                                        </li>
                                        <li>
                                            <a href="#pill3" data-toggle="tab">Domicilio</a>
                                        </li>
                                        <li>
                                            <a href="#pill4" data-toggle="tab">Dependientes</a>
                                        </li>
                                        <li>
                                            <a href="#pill5" data-toggle="tab">Fotografia</a>
                                        </li>
                                        <li>
                                            <a href="#pill6" data-toggle="tab">Empresa</a>
                                        </li>
                                        <div class="pull-right">
                                            <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
                                      </div>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="pill1">
                                           <div class="col-lg-12">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        DATOS LABORALES
                                                    </header>
                                                    <div class="panel-body">
                                                        <div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-4">
                                                                    <?= $form->field($model, 'Nup')->widget(\yii\widgets\MaskedInput::className(), [
                                                                            'mask' => '999999999999',
                                                                        ]) ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?php
                                                                        echo $form->field($model, 'IdTipoDocumento')->widget(Select2::classname(), [
                                                                            'data' => ArrayHelper::map(Tipodocumento::find()->all(), 'IdTipoDocumento', 'DescripcionTipoDocumento'),
                                                                            'language' => 'es',
                                                                            'options' => ['placeholder' => ' Selecione ...'],
                                                                            'pluginOptions' => [
                                                                                'allowClear' => true
                                                                            ],
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">

                                                                    <?= $form->field($model, 'NumTipoDocumento')->widget(\yii\widgets\MaskedInput::className(), [
                                                                            'mask' => '999999999',
                                                                    ]) ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?php
                                                                    echo $form->field($model, 'DuiExpedido', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('PrimerNomEmpleado', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                    echo $form->field($model, 'DuiEl', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('PrimerNomEmpleado', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-1">
                                                                    <?= $form->field($model, 'DuiDe')->widget(\yii\widgets\MaskedInput::className(), [
                                                                        'mask' => '9999',
                                                                    ]) ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?= $form->field($model, 'NIsss')->widget(\yii\widgets\MaskedInput::className(), [
                                                                        'mask' => '999999999',
                                                                    ]) ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-2">
                                                                    <?php
                                                                        echo $form->field($model, 'IdInstitucionPre')->widget(Select2::classname(), [
                                                                            'data' => ArrayHelper::map(Institucionprevisional::find()->all(), 'IdInstitucionPre', 'DescripcionInstitucion'),
                                                                            'language' => 'es',
                                                                            'options' => ['placeholder' => ' Selecione...'],
                                                                            'pluginOptions' => [
                                                                                'allowClear' => true
                                                                            ],
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                                <div class="form-group col-lg-2">
                                                                    <?= $form->field($model, 'MIpsfa')->widget(\yii\widgets\MaskedInput::className(), [
                                                                            'mask' => '9999999999999999',
                                                                    ]) ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?= $form->field($model, 'Nit')->widget(\yii\widgets\MaskedInput::className(), [
                                                                        'mask' => '9999-999999-999-9',
                                                                    ]) ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?php
                                                                    echo $form->field($model, 'Profesion', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('CorreoElectronico', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="pill2">
                                            <div class="col-lg-12">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        DATOS PERSONALES
                                                    </header>
                                                    <div class="panel-body">
                                                        <div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                    echo $form->field($model, 'PrimerNomEmpleado', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('PrimerNomEmpleado', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                        <?php
                                                                        echo $form->field($model, 'SegunNomEmpleado', [
                                                                            'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                        ])->textInput()->input('SegunNomEmpleado', ['placeholder' => ""]);
                                                                        ?>
                                                                </div>
                                                                <div class= "col-lg-3">
                                                                    <?php
                                                                    echo $form->field($model, 'PrimerApellEmpleado', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('PrimerApellEmpleado', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                    echo $form->field($model, 'SegunApellEmpleado', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('SegunApellEmpleado', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                    echo $form->field($model, 'ApellidoCasada', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('ApellidoCasada', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                    echo $form->field($model, 'ConocidoPor', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('ConocidoPor', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                        echo '<label class="control-label">Fecha de Nacimiento</label>';
                                                                        echo DatePicker::widget([
                                                                            'model' => $model,
                                                                            'attribute' => 'FNacimiento',
                                                                            'options' => ['placeholder' => 'Ingrese..'],
                                                                            'pluginOptions' => [
                                                                                'autoclose' => true,
                                                                                'format' => 'yyyy/mm/dd'
                                                                            ]
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                        echo $form->field($model, 'IdEstadoCivil')->widget(Select2::classname(), [
                                                                            'data' => ArrayHelper::map(Estadocivil::find()->all(), 'IdEstadoCivil', 'DescripcionEstadoCivil'),
                                                                            'language' => 'es',
                                                                            'options' => ['placeholder' => ' Selecione ...'],
                                                                            'pluginOptions' => [
                                                                                'allowClear' => true
                                                                            ],
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="pill3">
                                            <div class="col-lg-12">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        DOMICILIO
                                                    </header>
                                                    <div class="panel-body">
                                                        <div>
                                                            <div class="row">
                                                                        <div class="form-group col-lg-6">
                                                                            <?php
                                                                            echo $form->field($model, 'Direccion', [
                                                                                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                            ])->textInput()->input('Direccion', ['placeholder' => ""]);
                                                                            ?>
                                                                        </div>
                                                                        <div class="form-group col-lg-3">
                                                                        <?php
                                                                        $catList=ArrayHelper::map(app\models\Departamentos::find()->all(), 'IdDepartamentos', 'NombreDepartamento' );
                                                                        echo $form->field($model, 'IdDepartamentos')->dropDownList($catList, ['id'=>'NombreDepartamento']);

                                                                        ?>
                                                                        </div>
                                                                        <div class="form-group col-lg-3">
                                                                            <?php
                                                                            echo $form->field($model, 'IdMunicipios')->widget(DepDrop::classname(), [
                                                                                'options'=>['id'=>'DescripcionMunicipios'],
                                                                                'pluginOptions'=>[
                                                                                'depends'=>['NombreDepartamento'],
                                                                                 'type' => DepDrop::TYPE_SELECT2,
                                                                                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                                                                'placeholder'=>'Seleccione...',
                                                                                'url'=>  \yii\helpers\Url::to(['empleado/subcat'])
                                                                                ]
                                                                                ]);
                                                                            ?>
                                                                        </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                    echo $form->field($model, 'CorreoElectronico', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('CorreoElectronico', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <?php echo $form->field($model, 'Genero')->dropDownList(['' => 'Seleccione...','Masculino' => 'Masculino', 'Femenino' => 'Femenino']); ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <?= $form->field($model, 'TelefonoEmpleado')->widget(\yii\widgets\MaskedInput::className(), [
                                                                    'mask' => '9999-9999',
                                                                ]) ?>
                                                                </div>

                                                                <div class="form-group col-lg-3">
                                                                    <?= $form->field($model, 'CelularEmpleado')->widget(\yii\widgets\MaskedInput::className(), [
                                                                    'mask' => '9999-9999',
                                                                ]) ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                              <div class="form-group col-lg-3">
                                                                  <?php
                                                                  echo $form->field($model, 'OtrosDatos', [
                                                                      'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                  ])->textInput()->input('CorreoElectronico', ['placeholder' => ""]);
                                                                  ?>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                         <div class="tab-pane" id="pill4">
                                            <div class="col-lg-12">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        DEPENDIENTES
                                                    </header>
                                                    <div class="panel-body">
                                                        <div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-8">
                                                                    <?php
                                                                    echo $form->field($model, 'Dependiente1', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('Dependiente1', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?php
                                                                        echo '<label class="control-label">Fecha de Nacimiento</label>';
                                                                        echo DatePicker::widget([
                                                                            'model' => $model,
                                                                            'attribute' => 'FNacimientoDep1',
                                                                            'options' => ['placeholder' => 'Ingrese..'],
                                                                            'pluginOptions' => [
                                                                                'autoclose' => true,
                                                                                'format' => 'yyyy/mm/dd'
                                                                            ]
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                                <div class="form-group col-lg-8">
                                                                    <?php
                                                                    echo $form->field($model, 'Dependiente2', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('Dependiente2', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?php
                                                                        echo '<label class="control-label">Fecha de Nacimiento</label>';
                                                                        echo DatePicker::widget([
                                                                            'model' => $model,
                                                                            'attribute' => 'FNacimientoDep2',
                                                                            'options' => ['placeholder' => 'Ingrese..'],
                                                                            'pluginOptions' => [
                                                                                'autoclose' => true,
                                                                                'format' => 'yyyy/mm/dd'
                                                                            ]
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                                <div class= "col-lg-8">
                                                                    <?php
                                                                    echo $form->field($model, 'Dependiente3', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('Dependiente3', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?php
                                                                        echo '<label class="control-label">Fecha de Nacimiento</label>';
                                                                        echo DatePicker::widget([
                                                                            'model' => $model,
                                                                            'attribute' => 'FNacimientoDep3',
                                                                            'options' => ['placeholder' => 'Ingrese..'],
                                                                            'pluginOptions' => [
                                                                                'autoclose' => true,
                                                                                'format' => 'yyyy/mm/dd'
                                                                            ]
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="col-lg-12">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        EN CASO DE EMERGENCIA
                                                    </header>
                                                    <div class="panel-body">
                                                        <div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-8">
                                                                    <?php
                                                                    echo $form->field($model, 'CasoEmergencia', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?= $form->field($model, 'TeleCasoEmergencia')->widget(\yii\widgets\MaskedInput::className(), [
                                                                    'mask' => '9999-9999',
                                                                ]) ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                     <?php
                                                                    echo $form->field($model, 'Beneficiario', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>

                                                                <div class="form-group col-lg-4">
                                                                    <?php echo $form->field($model, 'DocumentBeneficiario')->dropDownList(['Seleccione...' => 'Seleccione...','DUI' => 'DUI', 'NIT' => 'NIT']); ?>

                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?= $form->field($model, 'NDocBeneficiario')->widget(\yii\widgets\MaskedInput::className(), [
                                                                    'mask' => '99999999999999',
                                                                ]) ?>
                                                                </div>
                                                            </div>
                                                     </div>
                                                 </div>
                                            </section>
                                        </div>

                                        </div>
                                        <div class="tab-pane" id="pill5">
                                            <div class="col-lg-12">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        FOTOGRAFIA
                                                    </header>
                                                    <div class="panel-body">
                                                        <div>
                                                    <!-- // <?php
                                                    // echo $form->field($model, 'file')->widget(FileInput::classname(), [
                                                    //     'options' => ['accept' => 'uploads/*'],
                                                    //     'pluginOptions' => [
                                                    //         'previewFileType' => 'image',
                                                    //         'showUpload' => true,
                                                    //         'initialPreview'=> [
                                                    //             '<img src="../'.$model->EmpleadoImagen.'" class="file-preview-image">',
                                                    //         ],
                                                    //         'initialCaption'=> $model->EmpleadoImagen,
                                                    //
                                                    //     ],
                                                    //
                                                    //
                                                    // ]);
                                                    // echo FileInput::widget([
                                                    //           'model' => $model,
                                                    //           'attribute' => 'file',
                                                    //           'pluginOptions' => [
                                                    //               'initialPreview'=>[
                                                    //                   Html::img("../".$model->EmpleadoImagen)
                                                    //               ],
                                                    //               'overwriteInitial'=>true,
                                                    //               'initialCaption'=> $model->EmpleadoImagen,
                                                    //           ]
                                                    //       ]);
                                                    // ?> -->

                                                    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                                                          'options' => ['accept'=>'uploads/*'],
                                                          'pluginOptions'=>[
                                                            'previewFileType' => 'image',
                                                              'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
                                                              'showUpload' => true,
                                                              'initialPreview' => [
                                                                  $model->EmpleadoImagen ? Html::img('../'.$model->EmpleadoImagen
                                                                  ) : null, // checks the models to display the preview
                                                              ],
                                                              'initialCaption'=> $model->EmpleadoImagen,
                                                          ],
                                                      ]); ?>



                                                </div>
                                                    </div>
                                                </section>
                                            </div>

                                        </div>
                                        <div class="tab-pane" id="pill6">
                                            <div class="col-lg-12">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        EMPRESA
                                                    </header>
                                                    <div class="panel-body">
                                                        <div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-4">
                                                              <?php
                                                                $catList=ArrayHelper::map(app\models\Departamentoempresa::find()->all(), 'IdDepartamentoEmpresa', 'DescripcionDepartamentoEmpresa' );
                                                                        echo $form->field($model, 'IdDepartamentoEmpresa')->dropDownList($catList, ['id'=>'DescripcionDepartamentoEmpresa']);
                                                                        ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">

                                                                        <?php
                                                                            echo $form->field($model, 'IdPuestoEmpresa')->widget(DepDrop::classname(), [
                                                                                'options'=>['id'=>'DescripcionPuestoEmpresa'],
                                                                                'pluginOptions'=>[
                                                                                'depends'=>['DescripcionDepartamentoEmpresa'],
                                                                                 'type' => DepDrop::TYPE_SELECT2,
                                                                                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                                                                'placeholder'=>'Seleccione...',
                                                                                'url'=>  \yii\helpers\Url::to(['empleado/subpue'])
                                                                                ]
                                                                                ]);
                                                                            ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?php echo $form->field($model, 'SalarioNominal')->widget(MaskMoney::classname(), [
                                                                        'pluginOptions' => [
                                                                            'prefix' => '$ ',
                                                                            'allowNegative' => false
                                                                        ]
                                                                    ]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <?php
                                                                        echo $form->field($model, 'JefeInmediato')->widget(Select2::classname(), [
                                                                            'data' => ArrayHelper::map(Empleado::find()->where(['EmpleadoActivo' => 1])->all(), 'IdEmpleado', 'fullName'),
                                                                            'language' => 'es',
                                                                            'options' => ['placeholder' => ' Selecione ...'],
                                                                            'pluginOptions' => [
                                                                                'allowClear' => true
                                                                            ],
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                                <div class="form-group col-lg-5">
                                                                    <?php
                                                                    echo $form->field($model, 'HerramientasTrabajo', [
                                                                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                    ])->textInput()->input('CBancaria', ['placeholder' => ""]);
                                                                    ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <?php
                                                                        echo $form->field($model, 'IdTipoEmpleado')->widget(Select2::classname(), [
                                                                            'data' => ArrayHelper::map(Tipoempleado::find()->all(), 'IdTipoEmpleado', 'DescipcionTipoEmpleado'),
                                                                            'language' => 'es',
                                                                            'options' => ['placeholder' => ' Selecione ...'],
                                                                            'pluginOptions' => [
                                                                                'allowClear' => true
                                                                            ],
                                                                        ]);
                                                                        ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                              <div class="col-lg-6">
                                                                 <section class="panel">
                                                                     <header class="panel-heading">
                                                                         CUENTA BANCARIA
                                                                     </header>
                                                                     <div class="panel-body">
                                                                         <div>
                                                                             <div class="row">
                                                                                 <div class="form-group col-lg-6">
                                                                                     <?php
                                                                                     echo $form->field($model, 'CBancaria', [
                                                                                         'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
                                                                                     ])->textInput()->input('CBancaria', ['placeholder' => ""]);
                                                                                     ?>
                                                                                 </div>

                                                                                 <div class="form-group col-lg-6">
                                                                                     <?php
                                                                                         echo $form->field($model, 'IdBanco')->widget(Select2::classname(), [
                                                                                             'data' => ArrayHelper::map(Banco::find()->all(), 'IdBanco', 'DescripcionBanco'),
                                                                                             'language' => 'es',
                                                                                             'options' => ['placeholder' => ' Selecione ...'],
                                                                                             'pluginOptions' => [
                                                                                                 'allowClear' => true
                                                                                             ],
                                                                                         ]);
                                                                                         ?>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </section>
                                                             </div>
                                                             <div class="col-lg-6">
                                                                 <section class="panel">
                                                                     <header class="panel-heading">
                                                                         DEDUCCIONES
                                                                     </header>
                                                                     <div class="panel-body">
                                                                         <div>
                                                                             <div class="row">
                                                                               <div class="form-group col-lg-12">
                                                                                 <br>
                                                                                 <div class="form-group col-lg-3">
                                                                                    <?= $form->field($model, 'DeducIsssAfp')->checkbox() ?>

                                                                                 </div>
                                                                                 <div class="form-group col-lg-3">
                                                                                      <?= $form->field($model, 'DeducIsssIpsfa')->checkbox() ?>

                                                                                 </div>
                                                                                 <div class="form-group col-lg-3">
                                                                                     <?= $form->field($model, 'NoDependiente')->checkbox() ?>
                                                                                 </div>
                                                                                 <div class="form-group col-lg-3">
                                                                                     <?= $form->field($model, 'Pensionado')->checkbox() ?>
                                                                                 </div>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </section>
                                                             </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="col-lg-12">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        CONTRATACION Y FINALIZACION DE SERVICIO
                                                    </header>
                                                    <div class="panel-body">
                                                        <div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-4">
                                                                 <?php
                                                                echo '<label class="control-label">Fecha de Contratacion</label>';
                                                                echo DatePicker::widget([
                                                                    'model' => $model,
                                                                    'attribute' => 'FechaContratacion',
                                                                    'options' => ['placeholder' => 'Ingrese..'],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'format' => 'yyyy/mm/dd'
                                                                    ]
                                                                ]);
                                                                ?>
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                 <?php
                                                                echo '<label class="control-label">Fecha de Despido</label>';
                                                                echo DatePicker::widget([
                                                                    'model' => $model,
                                                                    'attribute' => 'FechaDespido',
                                                                    'options' => ['placeholder' => 'Ingrese..'],
                                                                    'pluginOptions' => [
                                                                        'autoclose' => true,
                                                                        'format' => 'yyyy/mm/dd'
                                                                    ]
                                                                ]);
                                                                ?>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <br>
                                                                        <?= $form->field($model, 'EmpleadoActivo')->checkbox() ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php ActiveForm::end(); ?>

               </div>
