<?php
    // 推送任务过去
    require('BeanStalk.class.php');
    $beanstalk = BeanStalk::open(array(
        'servers'       => array( '127.0.0.1:11300' )
    ));

    // 选择使用的tube
    $beanstalk->use_tube('test');
    
    $beanstalk->put(
        0,   // 任务优先级
        0,   // 不等待直接放到ready队列
        120, // 处理任务的时间
        'say hello world' // 处理任务内容
    );
