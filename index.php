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
$url = 'https://couponscorpion.com/category/100-off-coupons/';
$maxPages = 0;
$i=1;
$data = array(); 
while(true)
{
    $i++;
    $contents = file_get_contents($url);
    $articles = explode('category_free100',$contents);
    unset($articles[0]);
    for($j=1;$j<=count($articles);$j++)
    {
        $articles[$j] = explode('newscom_head_ajax',$articles[$j])[0];
    }
    foreach($articles as $article)
    {
        $title = between($article, 'alt="', '"/>');
        $url = between($article, '<a href="', '"');
        $date = between($article, '<span class="date_meta">', '</');
        $cat = between($article, '"https://couponscorpion.com/', '/');
        $desc = between($article, 'moblineheight15 mb15">', '</p>');
        
        
        $course = file_get_contents($url);
        $courseDet = explode('addtoany_content_bottom',$course);
        unset($courseDet[0]);
        for($j=1;$j<=count($courseDet);$j++)
        {
            $courseDet[$j] = explode('dynamic_link_warning',$courseDet[$j])[0];
        }
        $oldPrice = between($courseDet[1], '<del>','</del>');
        $newPrice = between($courseDet[1], '"rh_regular_price">','</span>');

        $fetch = $db->query('SELECT * FROM courses WHERE title="'.$title.'";');
        if($fetch->num_rows>0)
        {
            continue;
        }
        $sql = 'INSERT INTO courses (title, urlindirect, date, categorie, description, old_price, new_price) VALUES ("'.$title.'","'.$url.'","'.$date.'","'.$cat.'","'.$desc.'","'.$oldPrice.'","'.$newPrice.'")';
        $db->query($sql);
        
    }
    
    if(between($contents, 'next_paginate_link"><a href="', '"') === false)
    {
        break;
    }
    else
    {
        $url = between($contents, 'next_paginate_link"><a href="', '"');
    }
    if($i>$maxPages && $maxPages!=0)
    {
        break;
    }
}

exit;
print_r($data);
exit;
$test = $data['urls'][rand(0,count($data['urls'])-1)];
echo explode('</del>',explode('<del>',file_get_contents($test))[1])[0];
echo $test;
exit;
echo between(' <del>','</del>',file_get_contents($data['urls'][5]));
/*
$html = '<table><tr><th>ID</th><th>Title</th><th>Date</th><th>Link</th></tr>';
for($i=0;$i<count($data['titles']);$i++)
{
    $html .= '<tr><td>'.$i.'</td><td>'.$data['titles'][$i].'</td><td>'.$data['date'][$i].'</td><td><a href="?goto='.$data['urls'][$i].'">Goto</a></td></tr>';
}
$html .= '</table>';
echo $html;*/


/*$contents = file_get_contents($nextLink);
print_r(between($contents,'115" alt="','"'));
*/
//print_r($data);


//print_r(between($contents,'115" alt="','"'));
//print_r(between($contents,'>            <a class="img-centered-flex rh-flex-center-align rh-flex-justify-center" href="','/'));
//echo $contents;