<?php
// include '../include/database.php';
require_once("../include/database.php");
  class Menu
  {
      private $_db;

      public function __construct(){
             $this ->_db = new Database();
        }

      public function getMenu(){
             $menu = $this->_db->query("select distinct m.IdMenu ,DescripcionMenu, Icono from menu m
                  inner join menuusuario mu on m.IdMenu = mu.IdMenu
                  inner join usuario u on mu.IdUsuario = u.IdUsuario
                  where m.IdMenu <> 9 and m.IdMenu <> 8 and m.IdMenu between 1 and 30 and m.TipoMenu = 'Menu' and u.InicioSesion = '" . $_SESSION['user'] . "'
                  order by m.IdMenu
                  ") ;
             return $menu->fetchAll();
      }

      public function getSubmenu($id){
             $menu = $this->_db->query("
                select distinct me.DescripcionMenuDetalle, m.IdMenu, me.Url, me.Icono from menuusuario mu
                inner join menudetalle me on mu.IdMenuDetalle = me.IdMenuDetalle
                inner join menu m on me.IdMenu = m.IdMenu
                inner join usuario u on mu.IdUsuario = u.IdUsuario
                where mu.IdMenu = $id and mu.TipoPermiso = 1 and u.InicioSesion = '" . $_SESSION['user'] . "'") ;
             return $menu -> fetchAll();
      }
   }

?>
