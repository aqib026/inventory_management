<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bigcommerce\Api\Client as Bigcommerce;
use App\Keywords as Keywords;
class BcController extends Controller
{
    //
	public $cats,$product_price,$product_weight,$product_sku,$page_title,$colorIds,$sizeIds;

	public function __construct()
	{
		ini_set('default_socket_timeout', 6000);
		Bigcommerce::configure(array(
			'client_id' => 'hhkyml8ihpcie3yqtkobzakrs2wpw9v',
			'auth_token' => '9za4wg25i15lg2ybeybyw7oxgg0oiuj',
			'store_hash' => 'hd87wl03wf'
		));
	}

	public function fetch_orders(){

		$date  = date('r',strtotime("-1 days"));

		$filters = array('min_date_created' => $date);

		$orders = Bigcommerce::getOrders($filters);

	}

	public function uploadonfws($dc){

		ini_set('max_execution_time', 6000);

		$item = \App\Item::where('design_code',$dc)->first();

		$this->cats = $this->getCategory($item->category_id);	

		if($item->fws_price != '0.00')
			$this->product_price = $item->fws_price;
		else
			$this->product_price = $item->b2s_p;

		$this->product_weight = $item->weight;

		$this->product_sku = $item->design_code;

		$this->page_title =  Keywords::$page_titles[array_rand(Keywords::$page_titles)].' '.$item->title;

		$optionSet = $this->create_optionSet($item->title.' '.$this->product_sku);
		if(isset($optionSet->id)){
			$option_value = $this->create_options_values($optionSet,$item);
			$this->colorIds = $option_value[0];
			$this->sizeIds  = $option_value[1];
		}else{
			dd('Failed To Create The Option Set For the Products');
		}

		$product = $this->create_product($item,$optionSet);

		$this->add_images($product,$item);

		$this->add_skus($product,$item);

		$item->fws_product_id   = $product->id;
		$item->fws_link_rewrite = $product->custom_url;
		$item->save();
		
	}


	public  function add_skus($product,$item){
		try {	
			$c = Bigcommerce::getProductOptions($product->id);
			foreach($c as $v){
				if($v->display_name == 'Select Size'){
					$size_product_option_id = $v->id;
				}elseif($v->display_name == 'Select Color'){
					$color_product_option_id = $v->id;
				}
			}
		} catch(Bigcommerce\Api\Error $error) {
			echo $error->getCode();
			echo $error->getMessage();
		}
		foreach($item->sizeAndColors as $isc){
			$item_sku_code = $isc->design_code.'-'.$isc->color.'-'.$isc->size;
			$qty = ($isc->aqty == 0) ? $isc->qty : $isc->aqty;
			if($qty < 0 ) $qty = 5; 
			try {

				$c = Bigcommerce::createSku( $product->id, 
					array( 'sku'=>$item_sku_code,
						'inventory_level'=>$qty,
						'options'=>array( 
							array('product_option_id'=>$size_product_option_id,'option_value_id'=>$this->sizeIds[$isc->size]),
							array('product_option_id'=>$color_product_option_id,'option_value_id'=>$this->colorIds[$isc->color]) ) ) );
			} catch(Bigcommerce\Api\Error $error) {
				echo $error->getCode();
				echo $error->getMessage();
			}				
		}	

	}	
	public function create_product($item,$optionSet){
		try {
			$rand_keys = array_rand(Keywords::$large_keywords, 70);
			$meta_keywords_r = array();
			foreach($rand_keys as $k){
				$meta_keywords_r[]  = Keywords::$large_keywords[$k];
			}
			$line = implode(",",$meta_keywords_r);				
			$set = array(
				'name'=> $item->title,
				'page_title'=> $this->page_title,
				'custom_url'=> '/'.strtolower(str_replace(' ','-', $this->page_title)),
				'type'=>'physical',
				'price'=>$this->product_price,
				'retail_price'=> ( $this->product_price + ($this->product_price * 0.2) ),
				'description'=> '<p><ul><li>Style : '.$item->style.'</li><li>Design : '.$item->design.' </li><li>Fabric : '.$item->fabric.' </li></ul></p>',
				'sale_price'=>$this->product_price,
				'meta_keywords' => $line ,
				'meta_description' => Keywords::$meta_description." ".$item->page_title,
				'is_visible' => true,
				'availability' => 'available',	
				'weight' => $this->product_weight,
				'sku' => $this->product_sku,
				'option_set_id'  => $optionSet->id,
				'inventory_tracking' => 'sku',
				'categories'  => $this->cats,
			);
			$product = Bigcommerce::createProduct($set);
			return $product;
		} catch(Bigcommerce\Api\Error $error) {
			echo 'error in producct creation';
			echo $error->getCode();
			echo $error->getMessage();
		}
	}

	public function add_images($product,$item){
		foreach($item->images as $image){
			$img = 'http://casualwears.co.uk/public/images/large/'.$image->image;
			$c = Bigcommerce::createProductImage($product->id,array('image_file'=>$img,'description'=>$this->page_title));		
		}
	}

	public function create_optionSet($product_title){

		Bigcommerce::failOnError();

		$optionSet = Bigcommerce::createOptionSet(['name' => $product_title]);

		echo 'option_set_id : '.$optionSet->id;

		echo '<br />step 1. create option set ID DONE';

		return $optionSet;
	}	

	public function create_options_values($optionSet,$item){
			//Create Color With Options
			$color_option = Bigcommerce::createOption(['name' => 'Color ('.$this->page_title.')', 'display_name' => 'Select Color', 'type' => 'RT']);				
			$colorIds = array();
			$is_d = true;
			foreach($item->colors() as $isc){
				$opt_value = Bigcommerce::createOptionValue($color_option->id,array('label' => $isc->color,'value'=>$isc->color,'is_default'=>$is_d));
				$is_d = false;
				$colorIds[$opt_value->value] = $opt_value->id;
			}
			Bigcommerce::createOptionSetOption(['option_id' => $color_option->id], $optionSet->id);

			//Create Sizes With Options
			$size_option = Bigcommerce::createOption(['name' => 'Size ('.$this->page_title.')', 'display_name' => 'Select Size', 'type' => 'RT']);
			$sizeIds = array();
			$is_d = true;

			foreach($item->sizes() as $isc){			
				$opt_value = Bigcommerce::createOptionValue($size_option->id,array('label' => $isc->size,'value'=>$isc->size,'is_default'=>$is_d));
				$is_d = false;
				$sizeIds[$opt_value->value] = $opt_value->id;
			}
			Bigcommerce::createOptionSetOption(['option_id' => $size_option->id], $optionSet->id);

			return array($colorIds,$sizeIds);
		}		

	public function getCategory($id){
		$hawavee_cate = array(
			6  => array(50),
			27 => array(50),
			42 => array(50),
			54 => array(50),
			5   => array(49),
			26  => array(49),
			41  => array(49),
			53  => array(49),
			4   => array(48),
			25  => array(48),
			40  => array(48),
			52  => array(48),
			7  => array(56 , 57 , 58 , 59 , 60 , 61 , 62),
			8  => array(63 , 64 , 65 , 70),
			9  => array(52 , 102 , 53 , 54),
			10 => array(80),
			11 => array(77),
			12 => array(77,81),
			13 => array(79),
			14 => array(66 , 71 ),
			28 => array(56 , 57 , 58),
			29 => array(56 , 57 , 58 , 59 , 60),
			30 => array(63 , 64, 65),
			32 => array(71 , 72, 73 , 74),
			31 => array(83),
			43 => array(56 , 59 ,60),
			44 => array(63 , 64, 65),
			45 => array(77),
			46 => array(71 , 72, 73 , 74),
			55 => array(63 , 64, 65),
			56 => array(56 , 57 , 58 , 59 , 60),
			57 => array(77),
			58 => array(71 , 72, 73 , 74),
			69 => array(78 , 56 , 57),
			70 => array(78 , 56 , 57),
			71 => array(78 , 56 , 57),
			16 => array(88),
			17 => array(85),
			18 => array(90),
			19 => array(87),
			20 => array(86),
			21 => array(87),
			33 => array(88),
			34 => array(85),
			35 => array(89),
			36 => array(87),
			47 => array(85),
			48 => array(87),
			49 => array(87),
			50 => array(89),
			60 => array(88),
			61 => array(87),
			62 => array(87),
			63 => array(86),
			64 => array(86),
			65 => array(86),
			66 => array(86),
			67 => array(86),
			22 => array(91 ,50),
			23 => array(93 ,50),
			24 => array(94 ,50),
			37 => array(91 ,50),
			38 => array(94 ,50),
			39 => array(93 ,50),
		);	
		if( isset($hawavee_cate[$id]) )
			$cat = $hawavee_cate[$id];

		$cat[] = '96';
		return $cat;	
	}

}
