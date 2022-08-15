<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

use \DTS\eBaySDK\Sdk;
use \DTS\eBaySDK\Trading;
use \DTS\eBaySDK\FileTransfer;

use App\Item;
use Illuminate\Support\Facades\Input;
//Ebay Sandbox Credentials
// aqib026@gmail.com  / Word@Pass123

class EbayController extends Controller
{
	private $ebay_sandbox = false;

	public function getHawaveeCats(){
		$cats = \App\Category::get();
		
		return view('ebay/form')->with(compact('cats','match'));
	}

	public function saveHawaveeCats(){

            \App\EbayHawaCat::truncate();
            $cats = Input::get('ebay_cat');
            foreach($cats as $hid => $ebid){
            	if($hid != '' && $ebid != ''){
	            	$model = new \App\EbayHawaCat;
	            	$model->hawavee_id =  $hid;
	            	$model->ebay_id =  $ebid;
	            	$model->save();            		
            	}
            }
		 return redirect('/hawavee_cats/');
	}

	public function getUserAccess(){
    	$member_id = \Auth::user()->member_id;
		/**
		 * Create the service object.
		 */
		$credentials = $this->getEbayCredentials();

		$service = new Services\TradingService([
		    'credentials' => $credentials,
		    'siteId'      => Constants\SiteIds::GB,
		    'sandbox' => $this->ebay_sandbox
		]);		
		if($this->ebay_sandbox == true)
			$RuName = array('RuName' => 'Aaqib_Javed-AaqibJav-hawave-svqmj' );
		else
			$RuName = array('RuName' => 'Aaqib_Javed-AaqibJav-hawave-jzbhjuqnp' );

		$request = new Types\GetSessionIDRequestType($RuName);

		/**
		 * Send the request.
		 */
		$response = $service->GetSessionID($request);
		$session=$response->SessionID;
		$sessidparam=urldecode('SessIdParam='.$session);

		/****rediect to ebay signin****/
		if($this->ebay_sandbox == true)
			header("Location: https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn&runame=".$RuName['RuName']."&SessID=".$session."&ruparams=".$sessidparam);
		else
			header("Location: https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&runame=".$RuName['RuName']."&SessID=".$session."&ruparams=".$sessidparam);

		die('ff');


	}

    public function acceptedURL()
    {
    	$member_id = \Auth::user()->member_id;
		/**
		 * Create the service object.
		 */
		$credentials = $this->getEbayCredentials();

		$service = new Services\TradingService([
		    'credentials' => $credentials,
		    'siteId'      => Constants\SiteIds::GB,
		    'sandbox' => $this->ebay_sandbox
		]);		

		$SessionId = array('SessionID' => $_GET['SessIdParam'] );

		$request = new Types\FetchTokenRequestType($SessionId);

		/**
		 * Send the request.
		 */
		$response = $service->FetchToken($request);		

		if(isset($response->eBayAuthToken)){

			$user = \App\EbayToken::where('user_member_id',$member_id)->first();

			if($user == null){
				$et = new \App\EbayToken;
				$et->user_member_id = $member_id;
				$et->auth_token = $response->eBayAuthToken;
				$et->save();
			}
		}else{
			die('Authentication token not found');
		}

    }

    public function declineURL(){
    	die('access denied');
    }


    public function viewEbayItems(Request $request)
    {
	
		$credentials = $this->getEbayCredentials();

		$auth_token = $this->getOAuthToken();
	   
		$service = new Services\TradingService([
		    'credentials' => $credentials,
		    'siteId'      => Constants\SiteIds::GB,
		    'sandbox' => $this->ebay_sandbox
		]);

		/**
		 * Create the request object.
		 */
		$request = new Types\GetMyeBaySellingRequestType();
		
		/**
		 * An user token is required when using the Trading service.
		 */
		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $auth_token;
		
		/**
		 * Request that eBay returns the list of actively selling items.
		 * We want 10 items per page and they should be sorted in descending order by the current price.
		 */
		$request->ActiveList = new Types\ItemListCustomizationType();
		$request->ActiveList->Include = true;
		$request->ActiveList->Pagination = new Types\PaginationType();
		$request->ActiveList->Pagination->EntriesPerPage = 10;
		$request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;
		$pageNum = 1;
		
		do {
		    $request->ActiveList->Pagination->PageNumber = $pageNum;
		    /**
		     * Send the request.
		     */
		    $response = $service->getMyeBaySelling($request);
		    /**
		     * Output the result of calling the service operation.
		     */
		    echo "==================\nResults for page $pageNum\n==================\n";
		    if (isset($response->Errors)) {
		        foreach ($response->Errors as $error) {
		            printf(
		                "%s: %s\n%s\n\n",
		                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
		                $error->ShortMessage,
		                $error->LongMessage
		            );
		        }
		    }
		    if ($response->Ack !== 'Failure' && isset($response->ActiveList)) {
		        foreach ($response->ActiveList->ItemArray->Item as $item) {
		            printf(
		                "<br /> (%s) %s: %s %.2f",
		                $item->ItemID,
		                $item->Title,
		                $item->SellingStatus->CurrentPrice->currencyID,
		                $item->SellingStatus->CurrentPrice->value
		            );
		        }
		    }
		    $pageNum += 1;
		} while (isset($response->ActiveList) && $pageNum <= $response->ActiveList->PaginationResult->TotalNumberOfPages);

    }

    public function postItemEbay(Request $request, $item_id)
    {
    	$template = \App\EbayTemplate::find($request->get('template_id')); 
    	
    	$db_item = Item::find($item_id);
    	$ebay_category_id = $db_item->third_category->ebayCategory->ebay_id;


    	$item_description = $this->updateTags($template->item_description);
    	 //var_dump($item_description);

    	 //dd($db_item->third_category	);

    	$colors = $db_item->sizeAndColors->pluck('color')->unique()->toArray();
    	$sizes = $db_item->sizeAndColors->pluck('size')->unique()->toArray();
    	// dd($sizes);
    	// dd($sizes);

	    $credentials = $this->getEbayCredentials();

		$auth_token = $this->getOAuthToken();

	    /**
		 * Create the service object.
		 */
		$service = new Services\TradingService([
		    'credentials' => $credentials,
		    'sandbox'     => $this->ebay_sandbox,
		    'siteId'      => Constants\SiteIds::GB
		]);
		/**
		 * Create the request object.
		 */
		$request = new Types\AddFixedPriceItemRequestType();

		/**
		 * An user token is required when using the Trading service.
		 */
		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $auth_token;

		/**
		 * Begin creating the fixed price item.
		 */
		$item = new Types\ItemType();

		/**
		 * We want a multiple quantity fixed price listing.
		 */
		$item->ListingType = Enums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
		// $item->Quantity = 5;

		/**
		 * Let the listing be automatically renewed every 30 days until cancelled.
		 */
		$item->ListingDuration = Enums\ListingDurationCodeType::C_GTC;
		/**
		 * The cost of the item is $19.99.
		 * Note that we don't have to specify a currency as eBay will use the site id
		 * that we provided earlier to determine that it will be United States Dollars (USD).
		 */

		// $item->StartPrice = new Types\AmountType(['value' => floatval($db_item->sc_price)]);
		
		/**
		 * Allow buyers to submit a best offer.
		 */
		// $item->BestOfferDetails = new Types\BestOfferDetailsType();
		// $item->BestOfferDetails->BestOfferEnabled = true;
		
		/**
		 * Automatically accept best offers of $17.99 and decline offers lower than $15.99.
		 */
		// $item->ListingDetails = new Types\ListingDetailsType();
		// $item->ListingDetails->BestOfferAutoAcceptPrice = new Types\AmountType(['value' => 17.99]);
		// $item->ListingDetails->MinimumBestOfferPrice = new Types\AmountType(['value' => 15.99]);

		/**
		 * Provide a title and description and other information such as the item's location.
		 * Note that any HTML in the title or description must be converted to HTML entities.
		 */
		$item->Title = $db_item->title ? $db_item->title : $db_item->design_code;
		$item->Description = $item_description;
		$item->SKU = $db_item->design_code;
		
		// $item->Country = 'US';
		$item->Country = 'GB';
		$item->Location = 'Beverly Hills';
		// $item->PostalCode = '90210';
		$item->PostalCode = 'E10AA';
		
		/**
		 * This is a required field.
		 */
		// $item->Currency = 'USD';
		$item->Currency = 'GBP';
		
		$productDetails = new Types\ProductListingDetailsType();
		$productDetails->EAN = "Does not apply";
		$item->ProductListingDetails = $productDetails;

		/**
		 * Display a picture with the item.
		 */
		if($db_item->images){
			$item->PictureDetails = new Types\PictureDetailsType();
			$item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;
			
			
			foreach($db_item->images as $img){
				$item->PictureDetails->PictureURL[] = 'https://casualwears.co.uk/public/images/large/'.$img->image;	
			}
			
		}

		/**
		* Item Variations
		*/
		$item->Variations = new Types\VariationsType();

		/**
		 * Before we specify the variations we need to inform eBay all the possible
		 * names and values that the listing could use over its life time.
		 */
		
		$variationSpecificsSet = new Types\NameValueListArrayType();
		
		$nameValue = new Types\NameValueListType();
		$nameValue->Name = 'Color';
		$nameValue->Value = $colors;//['Red', 'White', 'Blue'];
		$variationSpecificsSet->NameValueList[] = $nameValue;
		
		$nameValue = new Types\NameValueListType();
		$nameValue->Name = "Size";
		$nameValue->Value = $sizes;//['S', 'M', 'L'];
		$variationSpecificsSet->NameValueList[] = $nameValue;
		
		$item->Variations->VariationSpecificsSet = $variationSpecificsSet;

		

		/**
		 * Variation
		 * SKU          - TS-W-S
		 * Color        - White
		 * Size (Men's) - S
		 * Quantity     - 5
		 * Price        - 10.99
		 *
		 * The SDK allows properties to be specified when constructing new objects.
		 * By taking advantage of this feature we can add a variation as follows.
		 */
		foreach ($db_item->sizeAndColors as $key => $variation) {
			$item->Variations->Variation[] = new Types\VariationType([
			    'SKU' => $variation->item_sku_code,
			    'Quantity' => 5,
			  //  'EAN' => mt_rand(),
			    'StartPrice' => new Types\AmountType(['value' => floatval($db_item->sc_price)]),
			    'VariationSpecifics' => [new Types\NameValueListArrayType([
			        'NameValueList' => [
			            new Types\NameValueListType(['Name' => 'Color', 'Value' => [$variation->color]]),
			            new Types\NameValueListType(['Name' => "Size", 'Value' => [$variation->size]])
			        ]
			    ])],
			    'VariationProductListingDetails' =>[
			    	'EAN' => 'Does not apply'
			    ]			    
			]);
		}
		
		

		/**
		 * Item specifics describe the aspects of the item and are specified using a name-value pair system.
		 * For example:
		 *
		 *  Color=Red
		 *  Size=Small
		 *  Gemstone=Amber
		 *
		 * The names and values that are available will depend upon the category the item is listed in.
		 * Before specifying your item specifics you would normally call GetCategorySpecifics to get
		 * a list of names and values that are recommended by eBay.
		 * Showing how to do this is beyond the scope of this example but it can be assumed that
		 * a call has previously been made and the following names and values were returned.
		 *
		 * Brand="Handmade"
		 * Style=Basic Tee
		 * Size Type=Regular
		 * Material=100% Cotton
		 *
		 * It is important to note that item specifics Style and Size Type are required for the
		 * category that we are listing in.
		 */
		
		$item->ItemSpecifics = new Types\NameValueListArrayType();

		$specific = new Types\NameValueListType();
		$specific->Name = 'Brand';
		$specific->Value[] = $db_item->brand;
		$item->ItemSpecifics->NameValueList[] = $specific;

		/**
		 * This shows an alternative way of adding a specific.
		 */
		$item->ItemSpecifics->NameValueList[] = new Types\NameValueListType([
		    'Name' => 'Style',
		    'Value' => [$db_item->style]
		]);
		
		// dd($sizes[2]);
		
		// $specific = new Types\NameValueListType();
		// $specific->Name = 'Size Type';
		// $specific->Value = ['regular'];
		// $item->ItemSpecifics->NameValueList[] = $specific;

		$specific = new Types\NameValueListType();
		$specific->Name = 'Material';
		$specific->Value[] = $db_item->fabric;
		$item->ItemSpecifics->NameValueList[] = $specific;


		/**
		 * List item in the Books > Audiobooks (29792) category.
		 */
		$item->PrimaryCategory = new Types\CategoryType();
		$item->PrimaryCategory->CategoryID = "$ebay_category_id";

		/**
		 * Tell buyers what condition the item is in.
		 * For the category that we are listing in the value of 1000 is for Brand New.
		 */
		$item->ConditionID = 1000;
		/**
		 * Buyers can use one of two payment methods when purchasing the item.
		 * Visa / Master Card
		 * PayPal
		 * The item will be dispatched within 1 business days once payment has cleared.
		 * Note that you have to provide the PayPal account that the seller will use.
		 * This is because a seller may have more than one PayPal account.
		 */
		$item->PaymentMethods = [
		    'CreditCard',
		    'PayPal'
		];
		$item->PayPalEmailAddress = 'rania@fashion-wholesalers.co.uk';
		$item->DispatchTimeMax = 1;
		/**
		 * Setting up the shipping details.
		 * We will use a Flat shipping rate for both domestic and international.
		 */
		$item->ShippingDetails = new Types\ShippingDetailsType();
		$item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_FLAT;
		/**
		 * Create our first domestic shipping option.
		 * Offer the Economy Shipping (1-10 business days) service at $2.00 for the first item.
		 * Additional items will be shipped at $1.00.
		 */
		$shippingService = new Types\ShippingServiceOptionsType();
		$shippingService->ShippingServicePriority = 1;
		// $shippingService->ShippingService = 'Other';
		$shippingService->ShippingService = 'UK_OtherCourier';
		$shippingService->ShippingServiceCost = new Types\AmountType(['value' => 2.50]);
		$shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 1.00]);
		$item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
		
		/**
		 * Create our second domestic shipping option.
		 * Offer the USPS Parcel Select (2-9 business days) at $3.00 for the first item.
		 * Additional items will be shipped at $2.00.
		 */
		// $shippingService = new Types\ShippingServiceOptionsType();
		// $shippingService->ShippingServicePriority = 2;
		// $shippingService->ShippingService = 'USPSParcel';
		// $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 3.00]);
		// $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 2.00]);
		// $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
		
		/**
		 * Create our first international shipping option.
		 * Offer the USPS First Class Mail International service at $4.00 for the first item.
		 * Additional items will be shipped at $3.00.
		 * The item can be shipped Worldwide with this service.
		 */
		// $shippingService = new Types\InternationalShippingServiceOptionsType();
		// $shippingService->ShippingServicePriority = 1;
		// $shippingService->ShippingService = 'USPSFirstClassMailInternational';
		// $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 4.00]);
		// $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 3.00]);
		// $shippingService->ShipToLocation = ['WorldWide'];
		// $item->ShippingDetails->InternationalShippingServiceOption[] = $shippingService;

		/**
		 * Create our second international shipping option.
		 * Offer the USPS Priority Mail International (6-10 business days) service at $5.00 for the first item.
		 * Additional items will be shipped at $4.00.
		 * The item will only be shipped to the following locations with this service.
		 * N. and S. America
		 * Canada
		 * Australia
		 * Europe
		 * Japan
		 */
		// $shippingService = new Types\InternationalShippingServiceOptionsType();
		// $shippingService->ShippingServicePriority = 2;
		// $shippingService->ShippingService = 'USPSPriorityMailInternational';
		// $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 5.00]);
		// $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 4.00]);
		// $shippingService->ShipToLocation = [
		//     'Americas',
		//     'CA',
		//     'AU',
		//     'Europe',
		//     'JP'
		// ];
		// $item->ShippingDetails->InternationalShippingServiceOption[] = $shippingService;
		/**
		 * The return policy.
		 * Returns are accepted.
		 * A refund will be given as money back.
		 * The buyer will have 14 days in which to contact the seller after receiving the item.
		 * The buyer will pay the return shipping cost.
		 */
		$item->ReturnPolicy = new Types\ReturnPolicyType();
		$item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';
		// $item->ReturnPolicy->RefundOption = 'MoneyBack';
		$item->ReturnPolicy->Refund = 'MoneyBack';
		$item->ReturnPolicy->ReturnsWithinOption = 'Days_14';
		$item->ReturnPolicy->ShippingCostPaidByOption = 'Buyer';
		/**
		 * Finish the request object.
		 */
		$request->Item = $item;

		// dd($item);
		/**
		 * Send the request.
		 */
		//dd($request);
		$response = $service->addFixedPriceItem($request);
		dd($response);
		/**
		 * Output the result of calling the service operation.
		 */
		if (isset($response->Errors)) {
		    foreach ($response->Errors as $error) {
		        // printf(
		        //     "%s: %s\n%s\n\n",
		        //     $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
		        //     $error->ShortMessage,
		        //     $error->LongMessage
		        // );

		        $error_type = $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error : ' : 'Warning : ';

		        $error_msg = $error_type . $error->ShortMessage . $error->LongMessage;

		    }

		    return redirect()->back()->with('error', $error_msg);
		}
		if ($response->Ack !== 'Failure') {
		    // printf(
		    //     "The item was listed to the eBay Sandbox with the Item number %s\n",
		    //     $response->ItemID
		    // );
			
			$db_item->ebayIds()->create(['ebay_id'=>$response->ItemID]);

		    return redirect()->back()->with('success',"The item was listed to the eBay Sandbox with the Item number : ".$response->ItemID);
		}
    }



    function getEbayOrders(){
    	$credentials = $this->getEbayCredentials();

		$auth_token = $this->getOAuthToken();

    	/**
		 * Create the service object.
		 */
		$service = new Services\TradingService([
		    'credentials' => $credentials,
		    'siteId'      => Constants\SiteIds::GB,
		    'sandbox'	  => $this->ebay_sandbox
		]);
		/**
		 * Create the request object.
		 */
		// $request = new Types\GetMyeBaySellingRequestType();
		$request = new Types\GetOrdersRequestType();
		// $request->DetailLevel = 'ReturnAll';

		$create_time_from = new \DateTime('2017-06-01 15:12:00');
		$request->CreateTimeFrom = $create_time_from;

		$create_time_to = new \DateTime();
		$request->CreateTimeTo = $create_time_to;
		// $request->CreateTimeTo='';
		$request->OrderRole = Enums\OrderRoleCodeType::C_SELLER;
		$request->OrderStatus= Enums\OrderStatusCodeType::C_ALL;


		/**
		 * An user token is required when using the Trading service.
		 */
		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $auth_token;
		/**
		 * Request that eBay returns the list of actively selling items.
		 * We want 10 items per page and they should be sorted in descending order by the current price.
		 */
		// $request->ActiveList = new Types\ItemListCustomizationType();
		// $request->ActiveList->Include = true;
		$request->Pagination = new Types\PaginationType();
		$request->Pagination->EntriesPerPage = 10;
		// $request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;
		$pageNum = 1;

		do {
		    $request->Pagination->PageNumber = $pageNum;
		    /**
		     * Send the request.
		     */
		    // $response = $service->getMyeBaySelling($request);
		    $response = $service->getOrders($request);
		    // echo "<pre>";
		    // print_r($response->toArray());
		    // echo "</pre>";
		    // die;
		    /**
		     * Output the result of calling the service operation.
		     */
		    echo "==================<br />Results for page $pageNum<br />==================<br /><br />";
		    if (isset($response->Errors)) {
		        foreach ($response->Errors as $error) {
		            printf(
		                "%s: %s<br />%s<br /><br />",
		                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
		                $error->ShortMessage,
		                $error->LongMessage
		            );
		        }
		    }
		    if ($response->Ack !== 'Failure' && isset($response->OrderArray)) {
		        foreach ($response->OrderArray->Order as $order) {
		        	$item = $order->TransactionArray->Transaction[0]->Item;
		            printf(
		                "(%s) %s: %s %s<br />",
		                $order->OrderID,
		                $order->BuyerUserID,
		                $order->OrderStatus,
		                $item->Title
		            );
		        }
		    }
		    $pageNum += 1;
		} while (isset($response) && $pageNum <= $response->PaginationResult->TotalNumberOfPages);

    }

    function getAllCategories(){
    	$credentials = $this->getEbayCredentials();

		$auth_token = $this->getOAuthToken();

    	/**
		 * Create the service object.
		 */
		$service = new Services\TradingService([
		    'credentials' => $credentials,
		    'siteId'      => Constants\SiteIds::GB,
		    'sandbox'	  => $this->ebay_sandbox
		]);

		/**
		 * Create the request object.
		 */
		$request = new Types\GetCategoriesRequestType();
		
		/**
		 * An user token is required when using the Trading service.
		 */
		$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
		$request->RequesterCredentials->eBayAuthToken = $auth_token;
		
		/**
		 * By specifying 'ReturnAll' we are telling the API return the full category hierarchy.
		 */
		$request->DetailLevel = ['ReturnAll'];
		
		/**
		 * OutputSelector can be used to reduce the amount of data returned by the API.
		 * http://developer.ebay.com/DevZone/XML/docs/Reference/ebay/GetCategories.html#Request.OutputSelector
		 */
		$request->OutputSelector = [
		    'CategoryArray.Category.CategoryID',
		    'CategoryArray.Category.CategoryParentID',
		    'CategoryArray.Category.CategoryLevel',
		    'CategoryArray.Category.CategoryName'
		];
		
		/**
		 * Send the request.
		 */
		$response = $service->getCategories($request);
		
		/**
		 * Output the result of calling the service operation.
		 */
		if (isset($response->Errors)) {
		    foreach ($response->Errors as $error) {
		        printf(
		            "%s: %s\n%s\n\n",
		            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
		            $error->ShortMessage,
		            $error->LongMessage
		        );
		    }
		}
		if ($response->Ack !== 'Failure') {
		    /**
		     * For the US site this will output approximately 18,000 categories.
		     */
		    foreach ($response->CategoryArray->Category as $category) {
		        $tab = '';
		        $tab = ($category->CategoryLevel == 1 ? '--' : ($category->CategoryLevel == 2 ? '----' : ($category->CategoryLevel == 3 ? '------' : ($category->CategoryLevel == 4 ? '--------':'')))); 
		        printf(
		            "%s Level %s : %s (%s) : Parent ID %s <br />",
		            $tab,
		            $category->CategoryLevel,
		            $category->CategoryName,
		            $category->CategoryID,
		            $category->CategoryParentID[0]
		        );
		    }
		}
    }

    public function categorySpecifics()
    {

    	/**
		 * Downloading the category specifics is a two step process.
		 *
		 * The first step is to use the Trading service to request the FileReferenceID and TaskReferenceID from eBay.
		 * This is done with the GetCategorySpecifics operation.
		 *
		 * The second step is to use the File Transfer service to download the file that contains the specifics.
		 * This is done with the downloadFile operation using the FileReferenceID and TaskReferenceID values.
		 *
		 * For more information, see:
		 * http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/GetCategorySpecifics.html#downloadFile
		 */
		/**
		 * Specify the numerical site id that we to download the category specifics for.
		 * Note that each site will have its own category structure and specifics.
		 */
		
		$credentials = $this->getEbayCredentials();
		$auth_token = $this->getOAuthToken();
		$siteId = Constants\SiteIds::GB;
		
		$sdk = new Sdk([
		    'credentials' => $credentials,
		    'authToken'   => $auth_token,
		    'siteId'      => $siteId,
		    'sandbox'	  => $this->ebay_sandbox
		]);

		/**
		 * Create the service object.
		 */
		$service = $sdk->createTrading();
		
		/**
		 * Create the request object.
		 */
		$request = new Trading\Types\GetCategorySpecificsRequestType();
		/**
		 * Request the FileReferenceID and TaskReferenceID from eBay.
		 */
		$request->CategorySpecificsFileInfo = true;
		/**
		 * Send the request.
		 */
		$response = $service->getCategorySpecifics($request);
		/**
		 * Output the result of calling the service operation.
		 */
		if (isset($response->Errors)) {
		    foreach ($response->Errors as $error) {
		        printf(
		            "%s: %s\n%s\n\n",
		            $error->SeverityCode === Trading\Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
		            $error->ShortMessage,
		            $error->LongMessage
		        );
		    }
		}

		if ($response->Ack !== 'Failure') {
		    /**
		     * Get the values that will be passed to the File Transfer service.
		     */
		    $fileReferenceId = $response->FileReferenceID;
		    $taskReferenceId = $response->TaskReferenceID;
		    printf(
		        "FileReferenceID [%s] TaskReferenceID [%s]\n",
		        $fileReferenceId,
		        $taskReferenceId
		    );
		    print("Downloading file...\n");
		    $service = $sdk->createFileTransfer();
		    $request = new FileTransfer\Types\DownloadFileRequest();
		    $request->fileReferenceId = $fileReferenceId;
		    $request->taskReferenceId = $taskReferenceId;
		    $response = $service->downloadFile($request);
		    if (isset($response->errorMessage)) {
		        foreach ($response->errorMessage->error as $error) {
		            printf(
		                "%s: %s\n\n",
		                $error->severity === FileTransfer\Enums\ErrorSeverity::C_ERROR ? 'Error' : 'Warning',
		                $error->message
		            );
		        }
		    }
		    if ($response->ack !== 'Failure') {
		        /**
		         * Check that the response has an attachment.
		         */
		        if ($response->hasAttachment()) {
		            $attachment = $response->attachment();
		            /**
		             * Save the attachment to file system's temporary directory.
		             */
		            $tempFilename = tempnam(sys_get_temp_dir(), 'category-specifics-').'.zip';
		            $fp = fopen($tempFilename, 'wb');
		            if (!$fp) {
		                printf("Failed. Cannot open %s to write!\n", $tempFilename);
		            } else {
		                fwrite($fp, $attachment['data']);
		                fclose($fp);
		                printf("File downloaded to %s\nUnzip this file to obtain the category item specifics.\n\n", $tempFilename);
		            }
		        } else {
		            print("Unable to locate attachment\n\n");
		        }
		    }
		}

    }


    private function getEbayCredentials()
    {
    	$ebay_token = auth()->user()->ebay_token;

    	if($this->ebay_sandbox == true){
    		$credentials = [
				'devId' => 'ba46025a-6232-4abb-9690-a6a555e19884',
	            'appId' => 'AaqibJav-hawavee-SBX-d8ad8ac16-cf0b5d30',
	            'certId' => 'SBX-8ad8ac16d2d6-245d-4b45-82ab-1962',
			];    			

    	}else{
			$credentials = [
				'devId' => 'ba46025a-6232-4abb-9690-a6a555e19884',
	            'appId' => 'AaqibJav-hawavee-PRD-445f8a2bd-e4466c40',
	            'certId' => 'PRD-45f8a2bd3c6c-36b0-433c-b398-9db2',
			];    		
    	}

		return $credentials;		
    }

    private function getOAuthToken()
    {
    	$ebay_token = auth()->user()->ebay_token;
    	return $ebay_token->auth_token;
    }


	/**
	* This method is used to replace tag in item description
	*
	*/

    private function updateTags($description)
    {
    	
    	return $description;
    }
}
