<?php

// Вычисление стоимости доставки посылок
class CalcCostParcelDelivery {

    // Функции для формул 

    // Описание:    Это формулы, по которым вычисляется стоимость перевозки
    // Принимает:   Количествео килограмм посылки
    // Возвращает:  Стоимость доставки этим перевозчиком

    // Формула для перевозчика 1
    private function formula_carrier1($input_kg) {
        $result_summ = 0;

        // Текстовое описание: 
        // До 10 кг берет 100 руб, все что cвыше 10 кг берет 1000 руб

        if($input_kg < 10) {
            $result_summ = 100;
        } else {
            $result_summ = 1000;
        }

        return $result_summ;
    }

    
    // Формула для перевозчика 2
    private function formula_carrier2($input_kg) {
        $result_summ = 0;

        // Округляем в большую сторону
        // Так, если мы введём 0.1кг, он рассчитает стоимость перевозки как за 1кг
        $input_kg = ceil($input_kg);

        // Текстовое описание: 
        // За каждый 1 кг берет 100 руб

        $result_summ = $input_kg * 100;

        return $result_summ;
    }


    // Формула для перевозчика 3
    private function formula_carrier3($input_kg) {
        $result_summ = 0;

        // Текстовое описание: 
        // Вычисление стоимости по гиперболе. Чем больше кг посылаем - тем ниже стоимость доставки

        for ($i = 1; $i <= $input_kg; $i++) {
            if ($i <= 10) {
                $result_summ += 100;
            } else {
                $result_summ += 1000 / $i;
            }
        }

        // Округляем сумму денег до 2х знаков после запятой
        $result_summ = round($result_summ, 2);

        return $result_summ;
    }

    // ...








    // Универсальная функция для рассчёта
    // Принимает: Номер перевозчика, и количество кг, которые нужно перевезти
    // Возвращает: Стоимость перевозки, в рублях
    public function Carrier($num_of_carrier, $input_kg) {
        // Проверяю на корректный ввод входного количества килограмм посылки
        $this->VereficInput($input_kg);

        // Если вход = 0, то сразу 0 и возвращаем
        if($input_kg == 0) return 0;

        switch ($num_of_carrier) {
            case 1:
                $result_summ = $this->formula_carrier1($input_kg); break;
            case 2:
                $result_summ = $this->formula_carrier2($input_kg); break;
            case 3:
                $result_summ = $this->formula_carrier3($input_kg); break;
            // ...

            default:
                exit("Неизвестный перевозчик: $num_of_carrier");
        }
        
        if($result_summ == 0) {
            exit("Произошла ошибка при рассчёте стоимости! Формула №$num_of_carrier вернула 0 рублей. Строка: " . __LINE__);
        }

        // Возвращаем результат: 
        // Количество рублей, за перевозку введённого количества кг
        return $result_summ;
    }

    /*
        // Примеры использования:

        echo "\n".$CalcCostParcelDelivery->Carrier(1, 20); // Вернёт 1000
        echo "\n".$CalcCostParcelDelivery->Carrier(2, 20); // Вернёт 2000
        echo "\n".$CalcCostParcelDelivery->Carrier(3, 20); // Вернёт 1668.77
    */


    // Функция, которая проверяет, корректное ли мы подали на вход значение килограмм
    private function VereficInput($input_kg) {
        // Если входное значение является числом
        if(is_numeric($input_kg)) {
            // Если количество кг < 0
            if($input_kg < 0) {
                exit("Возникла ошибка при выполнении рассчёта стоимости доставки! " . 
                "Входное значение количества килограмм меньше нуля: $" . "input_kg = " . $input_kg);
            }
        } else {
            exit("Возникла ошибка при выполнении рассчёта стоимости доставки! " . 
            "Входное значение не является числом: $" . "input_kg = " . $input_kg);
        }
    }
}

$CalcCostParcelDelivery = new CalcCostParcelDelivery();

// Вызываем метод класса
// echo $CalcCostParcelDelivery->VereficInput("ааа"); 

// echo "\n".$CalcCostParcelDelivery->Carrier1(20); 
// echo "\n".$CalcCostParcelDelivery->Carrier2(20); 
// echo "\n".$CalcCostParcelDelivery->Carrier3(20); 

// echo "\n".$CalcCostParcelDelivery->Carrier1(5); 
// echo "\n".$CalcCostParcelDelivery->Carrier2(5); 
// echo "\n".$CalcCostParcelDelivery->Carrier3(5); 


// echo "\n".$CalcCostParcelDelivery->Carrier1(100); 
// echo "\n".$CalcCostParcelDelivery->Carrier2(100); 
// echo "\n".$CalcCostParcelDelivery->Carrier3(100); 

echo "\n".$CalcCostParcelDelivery->Carrier(1, 20); 
echo "\n".$CalcCostParcelDelivery->Carrier(2, 20); 
echo "\n".$CalcCostParcelDelivery->Carrier(3, 20); 








































