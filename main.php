<?php

// Вычисление стоимости доставки посылок
class CalcCostParcelDelivery {

    // Функция, для рассчёта стоимости отправки посылок, перевозчиком №1
    // Принимает: Количествео килограмм посылки
    // Возвращает: Стоимость доставки этим перевозчиком
    public function Carrier1($input_kg) {
        // Проверяю на корректный ввод входного клоичества килограмм посылки
        $this->VereficInput($input_kg);

        $result_summ = 0;

        // Если вход = 0, то сразу 0 и возвращаем
        if($input_kg == 0) return 0;

            // Основная формула для рассчёта стоимости перевозки:
            if($input_kg < 10) {
                $result_summ = 100;
            } else {
                $result_summ = 1000;
            }

        // Возвращаем результат: 
        // Количество рублей, за перевозку введённого количества кг
        return $result_summ;
    }

    // Функция, для рассчёта стоимости отправки посылок, перевозчиком №2
    // Принимает: Количествео килограмм посылки
    // Возвращает: Стоимость доставки этим перевозчиком
    public function Carrier2($input_kg) {
        // Проверяю на корректный ввод входного клоичества килограмм посылки
        $this->VereficInput($input_kg);

        // Если вход = 0, то сразу 0 и возвращаем
        if($input_kg == 0) return 0;

        $result_summ = 0;

        // Основная формула для рассчёта стоимости перевозки:
        
            // Округляем в большую сторону
            // Так, если мы введём 0.1кг, он рассчитает стоимость перевозки как за 1кг
            $input_kg = ceil($input_kg);
            $result_summ = $input_kg * 100;

        // Возвращаем результат: 
        // Количество рублей, за перевозку введённого количества кг
        return $result_summ;
    }

    // Функция, для рассчёта стоимости отправки посылок, перевозчиком №2
    // Принимает: Количествео килограмм посылки
    // Возвращает: Стоимость доставки этим перевозчиком
    public function Carrier3($input_kg) {
        // Проверяю на корректный ввод входного клоичества килограмм посылки
        $this->VereficInput($input_kg);

        // Если вход = 0, то сразу 0 и возвращаем
        if($input_kg == 0) return 0;

        $result_summ = 0;

        // Основная формула для расчёта стоимости перевозки:

            for ($i = 1; $i <= $input_kg; $i++) {
                if ($i <= 10) {
                    $result_summ += 100;
                } else {
                    $result_summ += 1000 / $i;
                }
            }

            // Округляем сумму денег до 2х знаков после запятой
            $result_summ = round($result_summ, 2);

            // Добавил 3ю функцию - вычисление стоимости по гиперболе
            // Чем больше кг посылаем, тем ниже стоимость доставки

        // Возвращаем результат: 
        // Количество рублей, за перевозку введённого количества кг
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






































