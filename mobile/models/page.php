<?php
	class Page extends Db
	{		
		public $current_page;
		public $perpage;
		public $total;
		public $offset;
		public $url;
		function __construct($url,$current_page,$perpage,$total,$offset) {
			$this->url = $url;
			$this->current_page = $current_page;
			$this->perpage = $perpage;
			$this->total = $total;
			$this->offset = $offset;
		}
		//lay so luong san pham 				
		function paginate($url, $total, $current_page, $perpage, $offset){
			if($total <= 0) {
				return "";
			}
			$totalLinks = ceil($total/$perpage); 
			if($totalLinks <= 1) 
			{ 
				return ""; 
 			} 
 			$from = $current_page - $offset; 
 			$to = $current_page + $offset; 
 			//$offset quy định số lượng link hiển thị ở 2 bên trang hiện hành
 			//$offset = 2 và $page = 5,lúc này thanh phân trang sẽ hiển thị: 3 4  5​ 6 7 
 			if($from <= 0) {
 				$from = 1;
 				$to = $offset * 2;
 			}
 			if($to > $totalLinks) { 
 				$to = $totalLinks; 
 			} 
 			$link = ""; 
 			for ($j = $from; $j <= $to; $j++) {  
 				$link = $link."<p><a href = '$url?current_page=$j'> $j </a></p>"; 
 			}
 			return $link;
		}
		//pham trang cho ket qua tim kiem
		function paginateresult($url, $total, $current_page, $perpage, $offset){
			if(isset($_GET['key']))
			{
				$key = $_GET['key'];
			}
			if($total <= 0) {
				return "";
			}
			$totalLinks = ceil($total/$perpage); 
			if($totalLinks <= 1) 
			{ 
				return ""; 
 			} 
 			$from = $current_page - $offset; 
 			$to = $current_page + $offset; 
 			//$offset quy định số lượng link hiển thị ở 2 bên trang hiện hành
 			//$offset = 2 và $page = 5,lúc này thanh phân trang sẽ hiển thị: 3 4  5​ 6 7 
 			if($from <= 0) {
 				$from = 1;
 				$to = $offset * 2;
 			}
 			if($to > $totalLinks) { 
 				$to = $totalLinks; 
 			} 
 			$link = ""; 
 			for ($j = $from; $j <= $to; $j++) {  
 				$link = $link."<p><a href = '$url?current_page=$j&key=$key'> $j </a></p>"; 
 			}
 			return $link;
		}
	}