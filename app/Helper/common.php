<?php

function getDayName($day) {
    switch ($day) {
        case 6:
            return 'Saturday';
        case 7:
            return 'Sunday';
        case 1:
            return 'Monday';
        case 2:
            return 'Tuesday';
        case 3:
            return 'Wednesday';
        case 4:
            return 'Thursday';
        case 5:
            return 'Friday';
    }

    return '';
}
