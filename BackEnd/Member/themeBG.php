<?php
function getMusimSKRG() {
    $month = date('n');
    
    switch($month) {
        case $month >= 0 && $month <= 2 || $month == 12: 
            return 'winter';
        case $month >= 3 && $month <= 5:
            return 'spring';
        case $month >= 6 && $month <= 8:
            return 'summer';
        case $month >= 9 && $month <= 11:
            return 'autumn';
        default:
            return 'default';
    }
}

function getMusimBG() {
    $season = getMusimSKRG();
    
    $backgrounds = [
        'winter' => 'winter.gif',
        'spring' => 'spring.gif',
        'summer' => 'summer.gif',
        'autumn' => 'autumn.gif',
        'default' => 'default-bg.png'
    ];
    
    return $backgrounds[$season] ?? '../../Assets/Background/default-bg.png';
}
?>