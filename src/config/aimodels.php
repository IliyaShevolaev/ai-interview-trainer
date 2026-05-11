<?php 

return [
    'models' => [
        'ChatGPT 3.5' => 'openchat/openchat-7b:free',
        'Gemini Experemental 2.0' => 'google/gemini-exp-1206:free',
        'Qwen 2.5' => 'qwen/qwen2.5-vl-72b-instruct:free',
        'Nvidia Nemotron 3' => 'nvidia/nemotron-3-nano-omni-30b-a3b-reasoning:free',
    ],

    'default_model' => 'openchat/openchat-7b:free'
];