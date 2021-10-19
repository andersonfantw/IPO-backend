<?php
return [
    // 执行文件的路径,默认:/usr/bin/opencc
    'binary_path'=> env('OPENCC_BINARY', '/usr/bin/opencc'),
    // 预设配置文件夹的路径,默认:/usr/share/opencc
    'config_path'=> env('OPENCC_CONFIG', '/usr/share/opencc'),
];