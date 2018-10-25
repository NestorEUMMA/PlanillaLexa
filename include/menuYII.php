<?php 
use yii\widgets\Menu;
?>

      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">  
                  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-laptop"></i>
                          <span>Mantenimientos</span>
                      </a> 
                      <?php
                        echo Menu::widget([
                              'items' => [
                                  ['label' => 'Bancos', 'url' => ['banco/index']],
                                  ['label' => 'Catalogo de Cuentas', 'url' => ['catalogocuentas/index']],
                                  ['label' => 'Estado Civil', 'url' => ['estadocivil/index']],
                                  ['label' => 'Empleado', 'url' => ['empleado/index']],
                                  ['label' => 'Institucion Previsional', 'url' => ['institucionprevisional/index']],
                                  ['label' => 'Paises', 'url' => ['pais/index']],
                                  ['label' => 'Perfiles de Usuario', 'url' => ['puesto/index']],
                                  ['label' => 'Puestos Laborales', 'url' => ['puestoempresa/index']],
                                  ['label' => 'Usuarios', 'url' => ['usuario/index']],
                                  ['label' => 'Tipo Documento', 'url' => ['tipodocumento/index']],
                                  ['label' => 'Tipo Empleado', 'url' => ['tipoempleado/index']],
                                  ['label' => 'Departamento', 'url' => ['departamentos/index']],
                                  ['label' => 'Municipio', 'url' => ['municipios/index']],
                                  ['label' => 'Empresa', 'url' => ['empresa/index']],
                                  ['label' => 'Deducciones', 'url' => ['deduccionempleado/index']],
                                  ['label' => 'Tramos ISR', 'url' => ['tramoisr/index']],
                                  ['label' => 'Tramos ISSS', 'url' => ['tramoisss/index']],
                                  ['label' => 'Tramos AFP', 'url' => ['tramoafp/index']],
                              ],
                              'options' => array( 'class' => 'sub' ),
                          ]);
                       ?>
                  </li>
              </ul>
          </div>
      </aside> 