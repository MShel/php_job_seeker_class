# php_job_seeker_class
This class can search for jobs in different job sites. 

It takes a list of parameters to search for jobs like the job keywords, country, city, distance limit, and the job sites 
to search.  The class sends HTTP requests to the specified job sites to retrieve feeds of the pages of jobs that match the 
specified criteria.  
It returns an array with the details of the jobs found in all sites like the job title, description and job page URL.  
Currently it supports search for jobs in Craigslist, Indeed and Monster(All of the sites are done through public API).
