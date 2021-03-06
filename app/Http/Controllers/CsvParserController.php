<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CsvParserController extends Controller
{
    public function parse()
    {
        $filters = public_path("filterKeyWord/filter.txt");
        $myfile = fopen($filters, "r") or die("Unable to open file!");
        $filterWords = explode(",", fread($myfile, filesize($filters)));
        $trimmedArray = array_map('trim', $filterWords);

        fclose($myfile);


        $dir = public_path('input');
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (!in_array($file, ['.', '..'])) {
//                        echo $file . "<br>";

                        $fileName = rtrim($file, '.csv');
                        $file = public_path('input/' . $file);
                        $file = fopen($file, 'r');
                        $i = 1;
                        while (($line = fgetcsv($file, 0, "\t")) !== FALSE) {

                            if ($i <= 3) {
                                $headers[] = $line;
                            } else {
                                $x = $line[0];
                                $source = strtolower(mb_convert_encoding($fileName, 'UTF-16LE', 'UTF-8'));


                                if (mb_strpos($x, $source)) {
                                    $array[$fileName][] = $line;
                                } else {
                                    $otherLines[] = $line;
                                }
                            }
                            $i++;

                        }
                        fclose($file);


                        $test = array_merge($headers, $otherLines);
                        $putByCsvFileNameX = $fileName . '.csv';
                        $putByCsvFileNameX = 'C:\xampp\htdocs/csvparser/public/output - by csv file name/notIncludeKeywords/' . $putByCsvFileNameX;
                        foreach ($test as $key => $x) {
                            $test[$key] = implode(',', $x);
                        }

                        $file = fopen($putByCsvFileNameX, "w");

                        foreach ($test as $line) {

                            fputcsv($file, str_replace('"', '', explode(",", str_replace(' ', '', $line))), "\t");
                        }

                        fclose($file);


//
                        $test = array_merge($headers, $array[$fileName]);
                        $putByCsvFileName = $fileName . '.csv';
                        $putByCsvFileName = 'C:\xampp\htdocs/public/output - by csv file name/‏‏IncludeKeywords/' . $putByCsvFileName;
                        foreach ($test as $key => $x) {
                            $test[$key] = implode(',', $x);
                        }

                        $file = fopen($putByCsvFileName, "w");

                        foreach ($test as $line) {

                            fputcsv($file, str_replace('"', '', explode(",", str_replace(' ', '', $line))), "\t");
                        }

                        fclose($file);


//                        echo '<pre>';
//                        print_r($array);
                    }
//
                }
                closedir($dh);
            }
        }

        $this->parseByFilterKeyWord();
    }


    public function parseByFilterKeyWord()
    {
        $filters = public_path("filterKeyWord/filter.txt");
        $myfile = fopen($filters, "r") or die("Unable to open file!");
        $filterWords = explode(",", fread($myfile, filesize($filters)));
        $trimmedArray = array_map('trim', $filterWords);


        $dir = public_path('input');
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (!in_array($file, ['.', '..'])) {
//                        echo $file . "<br>";

                        $fileName = rtrim($file, '.csv');
                        $file = public_path('input/' . $file);
                        $file = fopen($file, 'r');
                        $i = 1;
                        while (($line = fgetcsv($file, 0, "\t")) !== FALSE) {

                            if ($i <= 3) {
                                $headers[] = $line;
                            } else {
                                foreach ($trimmedArray as $trimWord) {
                                    $x = $line[0];


                                    $source = strtolower(mb_convert_encoding($trimWord, 'UTF-16LE', 'UTF-8'));


                                    if (mb_strpos($x, $source)) {
                                        $array[$trimWord][] = $line;
                                        $fileName = $trimWord;
                                    } else {
                                        $otherLines[$trimWord][] = $line;
                                    }
                                }

                            }
                            $i++;

                        }
                        fclose($file);

                        foreach ($trimmedArray as $fileName) {

                            $test = array_merge($headers, $otherLines[$fileName]);
                            $putByCsvFileNameX = $fileName . '.csv';
                            $putByCsvFileNameX = 'C:\xampp\htdocs/public/Output- by filter_txt/notIncludeKeywords/' . $putByCsvFileNameX;
                            foreach ($test as $key => $x) {
                                $test[$key] = implode(',', $x);
                            }

                            $file = fopen($putByCsvFileNameX, "w");

                            foreach ($test as $line) {

                                fputcsv($file, str_replace('"', '', explode(",", str_replace(' ', '', $line))), "\t");
                            }

                            fclose($file);
                        }



                        foreach ($trimmedArray as $fileName) {


                            $test = array_merge($headers, $array[$fileName]);
                            $putByCsvFileName = $fileName . '.csv';
                            $putByCsvFileName = 'C:\xampp\htdocspublic/Output- by filter_txt/IncludeKeywords/' . $putByCsvFileName;
                            foreach ($test as $key => $x) {
                                $test[$key] = implode(',', $x);
                            }

                            $file = fopen($putByCsvFileName, "w");

                            foreach ($test as $line) {

                                fputcsv($file, str_replace('"', '', explode(",", str_replace(' ', '', $line))), "\t");
                            }

                            fclose($file);
                        }


//                        echo '<pre>';
//                        print_r($array);
                    }
//
                }
                closedir($dh);
            }
        }
        echo "It's done.. please check folders";
    }


}
