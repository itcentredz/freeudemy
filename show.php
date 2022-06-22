<?php

/*
    Outil développé par ITCentre Informatique
    Email:  itcentredz@gmail.com
    Tel:    (+213) 796069321 
*/

include 'configs.php';
function between($string, $string1, $string2)
{
    if(isset(explode($string1, $string)[1]))
    {
        if(isset(explode($string2, explode($string1, $string)[1])[0]))
        {
            return trim(explode($string2, explode($string1, $string)[1])[0]);
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

if(!isset($_GET['goto']))
{
    $courses = $db->query("SELECT * FROM courses ORDER BY date desc");
    $data = array();
    while($result = $courses->fetch_assoc())
    {
        $data[] = $result;
    }
    $pages = array_chunk($data, 100);

    if(isset($_GET['page']) && $_GET['page']>1)
    {
        $page = $pages[$_GET['page']-1];
    }
    else
    {
        $page = $pages[0];
    }
    $html = '<table><tr><th>ID</th><th>Title</th><th>Date</th><th>Link</th></tr>';
    for($i=0;$i<count($page);$i++)
    {
        $html .= '<tr><td>'.($i+1).'</td><td>'.$page[$i]['title'].'</td><td>'.$data[$i]['date'].'</td><td><a target="_blank"href="?goto='.$data[$i]['id'].'">Goto</a></td></tr>';
    }
    $html .= '</table>';

    if(isset($_GET['page']) && $_GET['page']>1)
    {
       $page = $_GET['page'];
    }
    else
    {
        $page = 1;
    }
    
    $html .= '<br><br>Pages :';

    for($i=0;$i<count($pages);$i++)
    {
        if($page == $i+1)
        {
            $html .= ($i+1).'&nbsp;';
        }
        else
        {
            $html .= '<a href="?page='.($i+1).'">'.($i+1).'</a>&nbsp;';
        }
    }





/*
    $html .= $page!=1?'<a href="?page=1">1</a>': '1';
    $html .= $page!=2?'<a href="?page=2">2</a>': '2';
    $html .= $page!=3?'...': '3';

    $html .= $page>2?'<a href="?page='.$page.'">'.$page.'</a>': '2';

*/

    echo $html;
}
else
{
    $course = $db->query("SELECT urldirect, urlindirect FROM courses WHERE id=".$_GET['goto'])->fetch_assoc();
    /*if(isset($course['urldirect']))
    {
        header('location: '.$course['urldirect']);
    }
    else*/
    {
        $data = file_get_contents($course['urlindirect']);
        $url = 'https://couponscorpion.com/scripts/udemy/out.php?go='.between($data, 'var sf_offer_url = \'', '\'');
        $course = $db->query("UPDATE courses SET urldirect='".$url."' WHERE id=".$_GET['goto']);
        header('location: '.$url);
    }
}