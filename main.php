<?php


// Вычисление стоимости доставки посылок
class CalcCostParcelDelivery {

    // Функции для формул 

    // Описание:    Это формулы, по которым вычисляется стоимость перевозки
    // Принимает:   Количествео килограмм посылки
    // Возвращает:  Стоимость доставки этим перевозчиком

    // Формулы используются в публичной процедуре Carrier

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

        if($input_kg < 1) $input_kg = ceil($input_kg);

        // Текстовое описание: 
        // Вычисление стоимости по гиперболе. Чем больше кг посылаем - тем ниже стоимость доставки каждого кг,
        // но стоимость каждого кг суммируется.

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
    // Принимает: Номер перевозчика, и количество кг которые нужно перевезти
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

        // Инициализируем класс, для использования методов
        $CalcCostParcelDelivery = new CalcCostParcelDelivery();

        // Перевозчик № 1, хотим перевезти 10 килограмм:
        echo "\n".$CalcCostParcelDelivery->Carrier(1, 10); // Вернёт 1000

        // Для использования других перевозчиков:
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




    // Это эксперементальная функция, которая принимает на вход только количество кг, которое нужно перевезти
    // И выводит в консоль наилучшую комбинацию из перевозчиков, которых нужно использовать,
    // что бы потратить наименьшее количество денег
    public function FindingBestSolution($input_kg) {
        $this->VereficInput($input_kg);
        $best_cost = PHP_INT_MAX;
        $best_combination = [];

        if($input_kg > 19) {
            exit("К сожалению, алгоритм не рассчитан на такие мощности. "
            . "Пожалуйста, введите число кг < 19");
        }        

        // Проходим все возможные комбинации количества килограмм для трех перевозчиков
        // Шаг = 0.1кг
        for ($kg1 = 0; $kg1 <= $input_kg; $kg1 += 0.1) {
            for ($kg2 = 0; $kg2 <= $input_kg - $kg1; $kg2 += 0.1) {
                $kg3 = $input_kg - $kg1 - $kg2;

                $cost1 = $this->Carrier(1, $kg1);
                $cost2 = $this->Carrier(2, $kg2);
                $cost3 = $this->Carrier(3, $kg3);

                $total_cost = $cost1 + $cost2 + $cost3;

                if ($total_cost < $best_cost) {
                    $best_cost = $total_cost;
                    $kg3 = round($kg3, 1);
                    $best_combination = [$kg1, $kg2, $kg3];
                }
            }
        }

        // Форматируем и выводим наилучшую комбинацию
        $result = "Наилучшая комбинация для перевозки {$input_kg} кг:\n";
        $result .= "Перевозчик 1: {$best_combination[0]} кг\n";
        $result .= "Перевозчик 2: {$best_combination[1]} кг\n";
        $result .= "Перевозчик 3: {$best_combination[2]} кг\n";
        $result .= "Общая стоимость: {$best_cost} рублей";

        return $result;

        // Эта функция сейчас работает только с 3мя перевозчиками, 
        // но её можно оптимизировать и для произвольного их количества, используя рекурсии
    }
}

$CalcCostParcelDelivery = new CalcCostParcelDelivery();

// Отправляем 1м перевозчиком 10 кг:
echo "\n".$CalcCostParcelDelivery->Carrier(1, 10);
echo "\n";

echo "\n".$CalcCostParcelDelivery->Carrier(1, 15); // Выведет 1000
echo "\n".$CalcCostParcelDelivery->Carrier(2, 15); // Выведет 1500
echo "\n".$CalcCostParcelDelivery->Carrier(3, 15); // Выведет 1389.26
echo "\n";

echo "\n".$CalcCostParcelDelivery->FindingBestSolution(15); // Выведет 600
echo "\n";

echo "\n".$CalcCostParcelDelivery->FindingBestSolution(11); // Выведет 200
echo "\n";










































