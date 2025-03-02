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

        // Текстовое описание: 
        // За каждый 1 кг берет 100 руб

        // Округляем в большую сторону
        // Так, если мы введём 0.1кг, он рассчитает стоимость перевозки как за 1кг
        $input_kg = ceil($input_kg);

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






    // Функции-обёртки

    // Функция, для рассчёта стоимости отправки посылок, перевозчиком №1
    // Принимает: Количествео килограмм посылки
    // Возвращает: Стоимость доставки этим перевозчиком
    public function Carrier1($input_kg) {
        // Проверяю на корректный ввод входного клоичества килограмм посылки
        $this->VereficInput($input_kg);

        // Если вход = 0, то сразу 0 и возвращаем
        if($input_kg == 0) return 0;

        // Получаем значение стоимосты, вычисляемое по формуле
        $result_summ = formula_carrier1($input_kg);

        if($result_summ == 0) {
            exit("Произошла ошибка при рассчёте стоимости! Формула вернула 0 рублей. Строка: " . __LINE__);
        }

        // Возвращаем результат: 
        // Количество рублей, за перевозку введённого количества кг
        return $result_summ;
    }

    public function Carrier2($input_kg) {
        $this->VereficInput($input_kg);

        if($input_kg == 0) return 0;

        $result_summ = formula_carrier2($input_kg);

        if($result_summ == 0) {
            exit("Произошла ошибка при рассчёте стоимости! Формула вернула 0 рублей. Строка: " . __LINE__);
        }

        return $result_summ;
    }

    public function Carrier3($input_kg) {
        $this->VereficInput($input_kg);

        // Если вход = 0, то сразу 0 и возвращаем
        if($input_kg == 0) return 0;

        $result_summ = formula_carrier3($input_kg);

        if($result_summ == 0) {
            exit("Произошла ошибка при рассчёте стоимости! Формула вернула 0 рублей. Строка: " . __LINE__);
        }

        return $result_summ;
    }

    // ...


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

    /*
        // Примеры использования:
    */
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


echo "\n".$CalcCostParcelDelivery->Carrier1(100); 
echo "\n".$CalcCostParcelDelivery->Carrier2(100); 
echo "\n".$CalcCostParcelDelivery->Carrier3(100); 






































