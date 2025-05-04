<?php
function getMusimSKRG() {
    $month = date('n');
    
    switch($month) {
        case 12:
        case 1:
        case 2:
            return 'winter';
        case 3:
        case 4:
        case 5:
            return 'spring';
        case 6:
        case 7:
        case 8:
            return 'summer';
        case 9:
        case 10:
        case 11:
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