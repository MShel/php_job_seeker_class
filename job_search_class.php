<?php
class jobseeker
{
    public $error= array();
    public $jobseek_res = array();
    
    public function __construct($data)
    {
        
        $this->keywords = $data['keywords'];
        $this->sites    = $data['sites'];
        $this->city     = $data['city'];
        $this->distanse = $data['distanse'];
        $this->count_vacansies = $data['max_item'];
        $this->check_functions($this->sites);
     }

     private function check_functions($sites)
     {
         $methods = get_class_methods('jobseeker');
         foreach ($sites as $site)
         {
             if (!in_array($site,$methods))
             {
                 $this->error[] = "This $site is not supported yet";
             }
             else
             {
                $this->jobseek_res[$site] = $this->$site();
             }    
         }
     }

  
     private function monster()
     {
        $words   = implode(" ",$this->keywords); 
        $i = 0;
        $url = ("http://rss.jobsearch.monster.com/rssquery.ashx?
                 cy=us
                 &where={$this->city}
                 &q={$words}
                 &rad={$this->distanse}
                 &baseurl=jobsearch.monster.com#
                 &rad_units=miles");
                 
        $xml_monster = simplexml_load_file($url);
            foreach ($xml_monster as $vacancie)
            {
                foreach ($vacancie->item as $item)
                {
                    if ($i<$this->count_vacansies)
                    {    
                        $vacancies['title'][]  =  $item->title;
                        $vacancies['link']["$item->title"]   =  $item->link;
                        $vacancies['descr']["$item->title"]  =  $item->description;
                        $i++;
                    }
                    else
                    {
                         return ($vacancies);
                    }  
                }
            }    
        return ($vacancies);

     }

     private function indeed()
     {
        $vacancies = array(); 
        $i = 0;
        $words   = implode("+",$this->keywords); 
        $url     = ("http://rss.indeed.com/rss?q={$words}&l={$this->city}&radius={$this->distanse}");
        $xml_indeed = simplexml_load_file($url);
            foreach ($xml_indeed as $vacancie)
            {
                foreach ( $vacancie->item as $item)
                {
                    if ($i<$this->count_vacansies)
                    {    
                        $vacancies['title'][]  =  $item->title;
                        $vacancies['link']["$item->title"]   =  $item->link;
                        $vacancies['descr']["$item->title"]  =  $item->description;
                        $i++;
                    }
                    else
                    {
                            return ($vacancies);
                    }    
                }
            }    
        return ($vacancies);
     }
     
     private function craigslist()
     {
        $vacancies = array(); 
        $city    = str_replace(" ","",$this->city);
        $words   = implode("%20",$this->keywords); 
        $url     = ("http://{$city}.craigslist.org/search/jjj?query={$words}&format=rss");
        $craig_xml = file_get_contents("$url");
		$xml = new SimpleXMLElement($craig_xml); 
		$i=0;
		
		foreach ($xml as $item)
		{
		        if ($i<$this->count_vacansies)
                {    
					$vacancieys['title'][]  = $item->title;
					$vacancieys['link']["$item->title"]   =  (string) $item->link;
					$vacancieys['descr']["$item->title"]  =  (string) $item->description;
					$i++;
				}
			    else
                {
                    return ($vacancieys);
                }  
		}

        return ($vacancies);
     }
  
     private function career_jet()
     {
        $vacancies = array(); 
        $i = 0;
        $words   = implode("%2C",$this->keywords); 
   
        $url     = ("http://www.careerjet.co.uk/search/rss.html?s={$words}&l={$this->city}&lid=12710&psz={$this->count_vacansies}&snl=100");
        
        $xml_jet = simplexml_load_file($url);
            foreach ($xml_jet as $vacancie)
            {
                foreach ( $vacancie->item as $item)
                {
                    if ($i<$this->count_vacansies)
                    {    
                        $vacancies['title'][]  =  $item->title;
                        $vacancies['link']["$item->title"]   =  $item->link;
                        $vacancies['descr']["$item->title"]  =  $item->description;
                        $i++;
                    }
                    else
                    {
                            return ($vacancies);
                    }    
                }
             }    
        return ($vacancies);
     }


}

?>
