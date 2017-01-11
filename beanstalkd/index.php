<?php
    require('BeanStalk.class.php');
    $beanstalk = BeanStalk::open(array(
        'servers'       => array( '127.0.0.1:11300' ),
        'select'        => 'random peek'
    ));
    
    $beanstalk->use_tube('foo');
    
    $beanstalk->put(0, 0, 120, 'say hello world');
     $beanstalk->watch('foo'); 
    $job = $beanstalk->reserve_with_timeout(); 
    echo $job->get();
    Beanstalk::delete($job);
