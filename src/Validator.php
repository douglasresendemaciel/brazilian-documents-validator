<?php

namespace DouglasResende\BrazilianDocumentsValidator;

use Illuminate\Validation\Validator as BaseValidator;

/**
 * Class Validator
 * @package DouglasResende\BrazilianDocumentsValidator
 */
class Validator extends BaseValidator
{
    /**
     * Valida se o CPF é válido
     * @param string $attribute
     * @param string $value
     * @return boolean
     */

    protected function validateCpf($attribute, $value)
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;

    }

    /**
     * Valida se o CNPJ é válido
     * @param string $attribute
     * @param string $value
     * @return boolean
     */
    protected function validateCnpj($attribute, $value)
    {
        $c = preg_replace('/\D/', '', $value);

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14) {
            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]) ;

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]) ;

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;

    }

    /**
     * Valida se o CNH é válido
     * @param string $attribute
     * @param string $value
     * @return boolean
     */

    protected function validateCnh($attribute, $value)
    {
        $ret = false;

        if ((strlen($input = preg_replace('/[^\d]/', '', $value)) == 11) && (str_repeat($input[1], 11) != $input)) {
            $dsc = 0;

            for ($i = 0, $j = 9, $v = 0; $i < 9; ++$i, --$j) {
                $v += (int)$input[$i] * $j;
            }

            if (($vl1 = $v % 11) >= 10) {
                $vl1 = 0;
                $dsc = 2;
            }

            for ($i = 0, $j = 1, $v = 0; $i < 9; ++$i, ++$j) {
                $v += (int)$input[$i] * $j;
            }

            $vl2 = ($x = ($v % 11)) >= 10 ? 0 : $x - $dsc;

            $ret = sprintf('%d%d', $vl1, $vl2) == substr($input, -2);
        }

        return $ret;
    }

    /**
     * Valida se o Título de Eleitor é válido
     * @param $attribute
     * @param $value
     * @return bool
     */
    protected function validateTituloEleitor($attribute, $value): bool
    {
        $state = substr($value, -4, 2);

        if (((mb_strlen($value) < 5) || (mb_strlen($value) > 13)) ||
            (str_repeat($value[1], mb_strlen($value)) == $value) ||
            ($state < 1 || $state > 28)) {
            return false;
        }

        $dv = substr($value, -2);

        $base = 2;

        $sequence = substr($value, 0, -4);

        for ($i = 0; $i < 2; $i++) {

            $factor = 9;
            $sum = 0;

            for ($j = (mb_strlen($sequence) - 1); $j > -1; $j--) {
                $sum += $sequence[$j] * $factor;

                if ($factor == $base) {
                    $factor = 10;
                }

                $factor--;
            }

            $digit = $sum % 11;

            if (($digit == 0) and ($state < 3)) {
                $digit = 1;
            } elseif ($digit == 10) {
                $digit = 0;
            }

            if ($dv[$i] != $digit) {
                return false;
            }

            switch ($i) {
                case '0':
                    $sequence = $state . $digit;
                    break;
            }
        }
        return true;
    }

    /**
     * Valida se o NIS é válido (PIS/PASEP/NIT/NIS)
     * @param $attribute
     * @param $value
     * @return bool
     */
    protected function validateNis($attribute, $value): bool
    {
        $nis = sprintf('%011s', $value);

        if (mb_strlen($nis) != 11 || preg_match("/^{$nis[0]}{11}$/", $nis)) {
            return false;
        }

        for ($d = 0, $p = 2, $c = 9; $c >= 0; $c--, ($p < 9) ? $p++ : $p = 2) {
            $d += $nis[$c] * $p;
        }

        return ($nis[10] == (((10 * $d) % 11) % 10));
    }

    /**
     * Valida se o CNS é válido (Cartão Ncional de Saúde)
     * @param $attribute
     * @param $value
     * @return bool
     */
    protected function validateCns($attribute, $value): bool
    {
        // códigos definitivos iniciam em 1 ou 2 / códigos provisórios iniciam em 7, 8 ou 9
        if (preg_match("/[1-2][0-9]{10}00[0-1][0-9]/", $value) || preg_match("/[7-9][0-9]{14}/", $value)) {

            $sum = 0;

            for ($i = 0; $i < mb_strlen($value); $i++) {
                $sum += $value[$i] * (15 - $i);
            }

            return $sum % 11 == 0;
        }
        return false;
    }

    /**
     * Valida se a CERTIDÃO é válida (nascimento, casamento, óbito)
     * @param $attribute
     * @param $value
     * @return bool
     */
    protected function validateCertidao($attribute, $value): bool
    {
        if (!preg_match("/[0-9]{32}/", $value)) {
            return false;
        }

        $num = substr($value, 0, -2);

        $dv = substr($value, -2);

        $dv1 = $this->weightedSumCertidao($num) % 11;

        $dv1 = $dv1 > 9 ? 1 : $dv1;

        $dv2 = $this->weightedSumCertidao($num.$dv1) % 11;

        $dv2 = $dv2 > 9 ? 1 : $dv2;

        // Compara o dv recebido com os dois numeros calculados
        if ($dv === $dv1.$dv2) {
            return true;
        }

        return false;
    }

    /**
     * @param $value
     * @return int
     */
    private function weightedSumCertidao($value): int
    {
        $sum = 0;

        $multiplier = 32 - mb_strlen($value);

        for ($i = 0; $i < mb_strlen($value); $i++) {
            $sum += $value[$i] * $multiplier;
            $multiplier += 1;
            $multiplier = $multiplier > 10 ? 0 : $multiplier;
        }

        return $sum;
    }
}
