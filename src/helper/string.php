<?php

function string_slug(string $raw_string): string
{
    $pre_formated_string = mb_strtolower(html_entity_decode($raw_string));

    $formats = [
        "À" => "a",
        "Á" => "a",
        "Â" => "a",
        "Ã" => "a",
        "Ä" => "a",
        "Å" => "a",
        "Æ" => "a",
        "Ç" => "c",
        "È" => "e",
        "É" => "e",
        "Ê" => "e",
        "Ë" => "e",
        "Ì" => "i",
        "Í" => "i",
        "Î" => "i",
        "Ï" => "i",
        "Ð" => "d",
        "Ñ" => "n",
        "Ò" => "o",
        "Ó" => "o",
        "Ô" => "o",
        "Õ" => "o",
        "Ö" => "o",
        "Ø" => "o",
        "Ù" => "u",
        "Ú" => "u",
        "Û" => "u",
        "Ü" => "u",
        "ü" => "u",
        "Ý" => "y",
        "Þ" => "p",
        "ß" => "b",
        "à" => "a",
        "á" => "a",
        "â" => "a",
        "ã" => "a",
        "ä" => "a",
        "å" => "a",
        "æ" => "a",
        "ç" => "c",
        "è" => "e",
        "é" => "e",
        "ê" => "e",
        "ë" => "e",
        "ì" => "i",
        "í" => "i",
        "î" => "i",
        "ï" => "i",
        "ð" => "o",
        "ñ" => "n",
        "ò" => "o",
        "ó" => "o",
        "ô" => "o",
        "õ" => "o",
        "ö" => "o",
        "ø" => "o",
        "ù" => "u",
        "ú" => "u",
        "û" => "u",
        "ý" => "y",
        "ý" => "y",
        "þ" => "b",
        "ÿ" => "y",
        "R" => "r",
        "r" => "r",
        '"' => " ",
        "!" => " ",
        "@" => " ",
        "#" => " ",
        "$" => " ",
        "%" => " ",
        "&" => " ",
        "*" => " ",
        "(" => " ",
        ")" => " ",
        "_" => " ",
        "-" => " ",
        "+" => " ",
        "=" => " ",
        "{" => " ",
        "[" => " ",
        "}" => " ",
        "]" => " ",
        "/" => " ",
        "?" => " ",
        ";" => " ",
        ":" => " ",
        "." => " ",
        "," => " ",
        "\\" => " ",
        "\\" => " ",
        "\\" => " ",
        "\n" => " ",
        "'" => " ",
        "<" => " ",
        ">" => " ",
        "°" => " ",
        "º" => " ",
        "ª" => " ",
    ];

    $slug = str_replace(
        ["-----", "----", "---", "--"],
        "-",
        str_replace(
            " ",
            "-",
            trim(strtr($pre_formated_string, $formats))
        )
    );

    return $slug;
}

function is_email(string $email): bool
{
    $filter = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($filter) {
        $data = $email;
        $format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match($format, $data)) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

/**
 * @param string $val
 * @param string $mask (Ex.: ###.###.###-##)
 * @return string
 */
function str_mask(string $val, string $mask): string
{
    $maskared = '';
    $k = 0;
    for ($i = 0; $i < (strlen($mask)); $i++) {
        if ($mask[$i] == '#') {
            if (isset ($val[$k])) {
                $maskared .= $val[$k];
                $k++;
            }
        } else {
            if (isset ($mask[$i])) {
                $maskared .= $mask[$i];
            }
        }
    }
    return $maskared;
}

function str_phone(string $phone): ?string
{
    $tel = preg_replace("/[^0-9]/", "", $phone);

    if (!strlen($tel) == '10' || !strlen($tel) == '11') {
        return null;
    }

    if (!empty ($tel)) {
        $zero = substr($tel, 0, 1);
        if ($zero == '0') {
            $tel = substr($tel, 1);
        }

        $ddd = substr($tel, 0, 2);
        $numero = substr($tel, 2);

        $primeiroNumero = substr($numero, 0, 1);
        if ($primeiroNumero == '9' || $primeiroNumero == '8') {
            if (strlen($numero) == '8') {
                $numero = '9' . $numero;
            }
        }

        $tel = $ddd . $numero;

        if (strlen($tel) == '10') {
            return str_mask($tel, '(##) ####-####');
        } else if (strlen($tel) == '11') {
            return str_mask($tel, '(##) #####-####');
        } else {
            return null;
        }
    }
    return null;
}
