<?php 
require_once ('job_search_class.php');
$data = array(
                'keywords' => array('php','linux','apache'),
                'sites'    => array('monster','indeed','craigslist','career_jet'),
                'city'     => 'Boston',
                'max_item' => 5,
                'distanse' => '150'  //in miles
);
$jobseekerobj=new jobseeker($data);
echo("<table style='font-family:arial;font-size:13;'>");
foreach ($jobseekerobj->jobseek_res as $res=>$data)
{
    echo("<tr><td><h3>".$res."</h3></td></tr>");
    foreach($data['title'] as $title)
    {
        echo("<tr><td>$title</td></tr>");
        echo("<tr><td>".$data['descr']["{$title}"]."<br></td></tr>");
        echo("<tr><td><i><a href='".$data['link']["{$title}"]."'>Link</a><br><br><br></td></tr>");
        
    }
        
}
echo("</table>");
?>
