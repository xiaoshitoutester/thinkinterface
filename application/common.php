<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/*
 * 分页逻辑
 * @arr 数组，需要分页的数据
 * @pageNum 每页展示多少条数据
 * @curPageNum 当前页码,默认第一页
 * @return [$tmp,$countPages];$tmp：arr、当前页的数据集合,$countPages: 总共的页数；
 */
function FenYe($arr, $pageNum, $curPageNum = 1){
    $dataNums = count($arr); // 总共的数据数目
    $countPages = ceil($dataNums / $pageNum); // 总共的页数
    $start = ($curPageNum - 1) * $pageNum; //起始位
    if ($curPageNum == $countPages){
        $end = $dataNums;//结束位
    }else{
        $end = ($start + $pageNum); //结束位
    }
    // 根据数组切片,[start,end)
    $tmp = array_slice($arr, $start, $end);
    return [$tmp,$countPages];

}
