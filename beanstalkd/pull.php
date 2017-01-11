<?php
	// 拉取回来 
    require('BeanStalk.class.php');
    $beanstalk = BeanStalk::open(array(
        'servers'       => array( '127.0.0.1:11300'),
        'connection_timeout'=>3
    ));

    // 选择使用的tube
    $beanstalk->use_tube('test');
    
    // 设置要监听的tube
	$beanstalk->watch('test');

	//查看监听的tube列表
	// var_dump($beanstalk->list_tubes(['test']));
    while (true) 
    {
        //获取任务，此为阻塞获取，直到获取有用的任务为止
        $job = $beanstalk->reserve(); //返回格式array('id' => 123, 'body' => 'hello, beanstalk')
        if ($job) {
            //处理任务
            $result = $job->get();
            //删除任务
            BeanStalk::delete($job);
        } else {
            //休眠任务
            BeanStalk::bury($job);
        }
        //跳出无限循环
        if (file_exists('shutdown')) {
            file_put_contents('shutdown', 'beanstalkd在'.date('Y-m-d H:i:s').'关闭');
            break;
        }
    }