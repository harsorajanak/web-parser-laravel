<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPHtmlParser\Dom;

class HelperController extends Controller
{
    //get all category from home page
    function getCategories($url){
        $dom = new Dom;
        $dom->loadFromFile($url);
        $content = $dom->find('section')[1];
        $content = $content->find('.row')[3];
        $content = $content->find('li');
        $data = [];
        if(count($content)){
            foreach ($content as $item){
                $item1 = $item->find('a');
                $set['href'] = $item1->getAttribute('href');
                $set['text'] = $item1->text;
                $data[] = $set;
            }
        }
        return $data;
    }
    //get company with pagination details
    function getCompanies($url){
        $dom = new Dom;
        $dom->loadFromFile($url);
        $table = $dom->find('table');
        $table = $table->find('tr');
        $data = [];
        $i = 0;
        if(count($table) > 0){
            foreach ($table as $item){
                if($i >= 1){
                    $item1 = $item->find('td');
                    if(count($item1) > 0){
                        $dataset['cin'] = $item1[0]->text;
                        $cmp = $item1[1]->find('a');
                        $dataset['company_name'] = $cmp->text;
                        $dataset['company_url'] = $cmp->getAttribute('href');
                        $dataset['class'] = $item1[2]->text;
                        $dataset['status'] = $item1[3]->text;
                        $data1[] = $dataset;
                    }
                }
                $i++;
            }
            $data['result'] = $data1;
        } else {
            $data['result'] = [];
        }

        $pagination = $dom->find('.pagination');
        $pagination = $pagination->find('li');
        $total = count($pagination);
        $i = 0;
        $pagedata = [];
        if(count($pagination) > 0){
            foreach ($pagination as $pages){
                $i++;
                //echo  $pages;
                $a =  $pages->find('a');
                //Prev
                if($i == 1){
                    $pageset['type'] = "Prev";
                    $pageset['is_splitter'] = '';
                    $pageset['is_active'] = '';
                    if($pages == "<li> </li>"){
                        $pageset['href'] = "";
                        $pageset['text'] = "";
                    } else {
                        $pageset['href'] = $a->getAttribute('href');
                        $pageset['text'] = $a->text;

                    }
                }

                //pages
                if($i > 1 && $i <= $total -1){


                    if($pages->getAttribute('class') == "splitter"){
                        $pageset['is_splitter'] = 'splitter';
                    } else {
                        $pageset['is_splitter'] = '';
                    }
                    $pageset['type'] = "Pages";
                    $pageset['href'] = $a->getAttribute('href');
                    $pageset['text'] = $a->text;
                    if($pages->getAttribute('class') == "active"){
                        $pageset['is_active'] = 'active';
                        $pageset['text'] = $a->find('strong')[0]->text;
                    } else {
                        $pageset['is_active'] = '';
                    }
                }

                //next
                if($i == $total){
                    $pageset['type'] = "Next";
                    $pageset['is_splitter'] = '';
                    $pageset['is_active'] = '';
                    if($pages == "<li> </li>"){
                        $pageset['href'] = "";
                        $pageset['href'] = "";
                    } else {
                        $pageset['href'] = $a->getAttribute('href');
                        $pageset['text'] = $a->text;
                    }
                }
                $pagedata[] = $pageset;

            }
            $data['pagination'] = $pagedata;
        } else {
            $data['pagination'] = [];
        }
        return $data;
    }

    function getCompanyDetails($url){
        $data = [];
        $dom = new Dom;
        $dom->loadFromFile(asset('test.html'));


        //company detailes
        $div0 = $dom->find('.roomy-5')[0];
        $table0 = $div0->find('table');
        $tr0 = $table0->find('tr');
        $array0 = ['cin','company_name','status','age','register_number','category','sub_category','class','roc','members'];
        $i = 0;
        foreach ($tr0 as $item){
            $td1 = $item->find('td')[1];
            $a = $td1->find('a');
            if($td1->find('a') != ""){
                $a->delete();
                $data[$array0[$i]] = $td1->text;
            } else {
                $data[$array0[$i]] = $td1->text;
            }
            $i++;
        }

        //contact details
        $div1 = $dom->find('.roomy-5')[1];
        $table1 = $div1->find('table');
        $tr1 = $table1->find('tr');
        $array1 = ['email','register_office'];
        $i1 = 0;
        foreach ($tr1 as $item){
            $td1 = $item->find('td')[1];

            $a = $td1->find('a');
            if($td1->find('a') != ""){
                $a->delete();
                $data[$array1[$i1]] = $td1->text;
            } else {
                $data[$array1[$i1]] = $td1->text;
            }
            $i1++;
        }

        //LISTING & ANNUAL COMPLAINCE DETAILS
        $div2 = $dom->find('#listingandannualcomplaincedetails')[0];
        $table2 = $div2->find('table');
        $tr2 = $table2->find('tr');
        $array2 = ['wether_listed','date_of_last_agm','date_of_bal_sheet'];
        $i2 = 0;
        foreach ($tr2 as $item1){
            $td2 = $item1->find('td')[1];
            if($td2 != ""){
                $a = $td2->find('a');
                if($a != ""){
                    $a->delete();
                    $data[$array2[$i2]] = $td2->text;
                } else {
                    $data[$array2[$i2]] = $td2->text;
                }
            } else {
                $data[$array2[$i2]] = "";
            }
            $i2++;
        }


        // location
        $div3 = $dom->find('#otherinformation')[0];
        $table3 = $div3->find('table');
        $tr3 = $table3->find('tr');
        $array3 = ['state','district','pin'];
        $i3 = 0;
        foreach ($tr3 as $item){
            $td3 = $item->find('td')[1];
            $td3 = $td3->find('a');
            $data[$array3[$i3]] = $td3->text;
            $i3++;
        }


        //Industry Classification:
        $div4 = $dom->find('#industryclassification')[0];
        $table4 = $div4->find('table');
        $tr4 = $table4->find('tr');
        $array4 = ['section','division','main_group','main_class'];
        $i4 = 0;
        foreach ($tr4 as $item1){
            $td4 = $item1->find('td')[1];
            if($td4 != ""){
                $a = $td4->find('a');
                if($a != ""){
                    $a->delete();
                    $data[$array4[$i4]] = $td4->text;
                } else {
                    $data[$array4[$i4]] = $td4->text;
                }
            }
            $i4++;
        }
        return $data;
    }
}
