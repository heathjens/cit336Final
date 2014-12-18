<?php
/* 
 * BYUI - CIT 336-03
 * Heather Jensen
 */

function GetPrimaryNavigationItems(){
    $navBar= array ('home' =>'Home','services'=> 'Services','portfolio' =>'Portfolio','gallery' =>'Gallery', 'contact' =>'Contact', 'login' =>'Login');

    
    if (CheckSession())
    {
        $navBar['menu'] = 'Menu';
        $navBar['logout'] = 'Log Out';
    }
    else
    {
        $navBar['login'] = 'Log In';
    }
    
    return $navBar;
}
    //This array in an array is saying that Related Articles goes under the Services tab, etc. 
   
function GetSubNavigationItems(){
   
    
    $subNavBar=array(
            array('Service', 'Services'),
            array('Articles', 'Services'),
            array('Graphics', 'Portfolio'),
            array('Design', 'Portfolio'),
            array('Programming', 'Portfolio'),
            array('About', 'Contact'));
       
    return $subNavBar;
}

function GetFooter(){
    $footerNav= array('teaching' =>'Teaching Presentation', 'site'=>'Site Plan', 'source'=>'Source Code');

    
    return $footerNav;
}

