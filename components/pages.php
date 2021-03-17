<?php

/* 
 * Copyright (C) 2014 themhz
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class pageloader
{

    private $page = null;

    public function __construct()
    {
    }


    public function load()
    {        
        if(isset($_SESSION["user"])){
            if (isset($_REQUEST['page'])) {
                $this->page = $_REQUEST['page'];
                $directory = getcwd() . "/pages/$this->page";
                //Check If the directory exists
                if (is_dir($directory)) {
                    //Load the directory
                    return $directory . '/' . $this->page . '.php';
                } else {
                    //Load the default directory
                    return getcwd() . "/pages/default/default.php";
                }
            }else {
                //Load the default directory
                return getcwd() . "/pages/default/default.php";
            }
         }else{
            return  getcwd() .'/pages/login/login.php';
            
         }
               
    }
}
