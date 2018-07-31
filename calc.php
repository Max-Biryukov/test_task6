<?php

/**
 * @param $num
 * @return mixed
 * Получение абсолютного значения без знака
 */

function getAbsValue( $num )
{
    return isNegative( $num ) ? substr_replace( $num, '', 0, 1 ) : $num;
}

/**
 * @param $a
 * @param $b
 * @return string
 * Расчет суммы чисел
 */

function getSum( $a, $b )
{

    $absA = getAbsValue( $a );
    $absB = getAbsValue( $b );

    $lenA = strlen( $absA );
    $lenB = strlen( $absB );

    $len = $lenA;

    //Если длина значений не равна, то добиваем нулями
    if( $lenA < $lenB ){

        $absA = str_repeat( '0', ($lenB - $lenA) ) . $absA;
        $len = $lenB;

    } elseif( $lenA > $lenB ) {

        $absB = str_repeat( '0', ($lenA - $lenB) ) . $absB;

    }

    $len--;

    $isNegativeA = isNegative( $a );
    $isNegativeB = isNegative( $b );

    if( !$isNegativeA && !$isNegativeB ){

        return sum( $absA, $absB, $len );

    } elseif( $isNegativeA && $isNegativeB ){

        return '-' . sum( $absA, $absB, $len );

    } elseif( ($isNegativeA && !$isNegativeB) || (!$isNegativeA && $isNegativeB) ){

        $values = sortValues( $absA, $absB, $len, $isNegativeA, $isNegativeB );
        return $values[ 2 ] . sum( $values[0], $values[1], $len, 'diff' );

    }

}

/**
 * @param $num1
 * @param $num2
 * @param $len
 * @param $isNegativeA
 * @param $isNegativeB
 * @return array
 * Вычисляет большее из чисел и возвращает массив значений: большее число, меньшее, знак результата суммирования
 */

function sortValues( $num1, $num2, $len, $isNegativeA, $isNegativeB )
{

    //Если два числа равны
    if( $num1 == $num2 ){

        return [
            $num1,
            $num2,
            '',
        ];

    }

    //Посимвольное сравнение
    for( $i = 0; $i <= $len; $i++ ){

        if( $num1{$i} > $num2{$i} ){
            //Если первое число больше и отрицательное, то результат отрицателен
            return [
                $num1,
                $num2,
                $isNegativeA === true ? '-' : '',
            ];

        } elseif( $num1{$i} < $num2{$i} ){
            //Если второе число больше и отрицательное, то результат отрицателен
            return [
                $num2,
                $num1,
                $isNegativeB === true ? '-' : '',
            ];

        }

    }

}

/**
 * @param $num
 * @return bool
 * Проверка на отрицательность числа
 */

function isNegative( $num )
{
    return substr( $num, 0, 1 ) === '-';
}

/**
 * @param $num1
 * @param $num2
 * @param $len
 * @param string $type
 * @return string
 * Расчет суммы или разности чисел
 */

function sum( $num1, $num2, $len, $type = 'sum' )
{

    $result = '';
    if( $type == 'sum' ){

        $additional = 0;
        for( $i = $len; $i >= 0; $i-- ){

            $sum = (int) $num1{$i} + (int) $num2{$i} + $additional ;
            $additional = 0;

            if( $sum > 9 ){

                $additional = 1;
                $sum = $sum - 10;

            }

            $result = $sum . $result;

        }

    } else {

        $additional = 0;

        for( $i = $len; $i >= 0; $i-- ){

            $diff = (int) $num1{$i} - (int) $num2{$i} - $additional ;
            $additional = 0;

            if( $diff < 0 ){

                $additional = 1;
                $diff = 10 + $diff;

            }
            $result = $diff . $result;

        }

    }

    return $result;

}

$a = '-149';
$b = '35535';
echo getSum( $a, $b );

die();