<?php

namespace App\Http\Controllers;

use App\PayPalLog;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use PayPal\Api\Payment;
use Paypalpayment;
use App\Http\Controllers\Controller;
use Exception;

class PaypalPaymentController extends Controller
{
    /**                        !!!!!!!!!!!!!!!!!!!!!!!!
     *    PayPalController created with the help of https://github.com/justgage  Thanks !!!!!!
     *                      https://github.com/justgage/ButterflyOils
     */

    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /*
     *   These construct set the SDK configuration dynamiclly,
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */
    public function __construct()
    {
        // ### Api Context
        // Pass in a `ApiContext` object to authenticate
        // the call. You can also send a unique request id
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly.

        $this->_apiContext = Paypalpayment::ApiContext(config('paypal_payment.Account.ClientId'),
            config('paypal_payment.Account.ClientSecret'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        echo "<pre>";

        $payments = Paypalpayment::getAll(array('count' => 1, 'start_index' => 0), $this->_apiContext);

        dd($payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store()
    {

        if (Cart::count()<1) {
             return redirect('/');
            exit(1);
        }


        $subtotal = (float) Cart::total();
        $shipping = 5.00;


        $payer = Paypalpayment::Payer();
        $payer->setPaymentMethod('paypal');

        // ### Items
        // These repersent the items in the cart
        $itemsArray = array();
        $cartItems = Cart::content()->toArray();




        foreach ($cartItems as $cartItem){
            $item = Paypalpayment::Item();
            $item->setCurrency( 'EUR' );
            $item->setName( $cartItem['name'] );
            $item->setPrice( $cartItem['price'] );
            $item->setQuantity( (string) $cartItem['qty'] );
            $item->setSku($cartItem['id']);

            $itemsArray[] = $item;
        }


        // add item to list
        $item_list =Paypalpayment::ItemList();
        $item_list->setItems($itemsArray);

        $details = Paypalpayment::Details();
        $details->setShipping($shipping)
                ->setSubtotal($subtotal);

        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.
        $amount = Paypalpayment::Amount();
        $amount->setCurrency("EUR");
        $amount->setTotal($subtotal + $shipping);
        $amount->setDetails($details);

        $transaction = Paypalpayment::Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Your transaction description');


        $redirect_urls =Paypalpayment::RedirectUrls();
        $redirect_urls->setReturnUrl(url('payment/ExecutePayment/?success=true'))
                      ->setCancelUrl(url('payment/ExecutePayment/?success=false'));

        $payment =Paypalpayment::Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));

        Log::info("cool ->". var_export($payment->toArray(), true) );

        try {
            $payment->create($this->_apiContext );
        } catch (Exception $e) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $e->getMessage() . PHP_EOL;
                $err_data = json_decode($e->getData(), true);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }

        // add payment ID to session
        // Session::put('paypal_payment_id', $payment->getId());
        // Session::put('bookId', $request->bookId);


        if(isset($redirect_url)) {
            // redirect to paypald

            return redirect($redirect_url);
        }

        // ### Get redirect url
        // The API response provides the url that you must redirect
        // the buyer to. Retrieve the url from the $payment->getLinks()
        // method
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirectUrl = $link->getHref();
                break;
            }
        }


        // ### Redirect buyer to PayPal website
        // Save the payment id so that you can 'complete' the payment
        // once the buyer approves the payment and is redirected
        // back to your website.
        //
        // It is not a great idea to store the payment id
        // in the session. In a real world app, you may want to
        // store the payment id in a database.




        $pay_id = $payment->getId();

        // store the payment_id
        $log = PayPalLog::firstOrNew( array("payment_id" => $pay_id) );
        $log->save();

        Session::put( 'log_id' , $log->id);


        if(isset($redirectUrl)) {
            return redirect($redirectUrl);
            exit;
        }
    }

    /**
     *
     */
    public function ExecutePayment()
    {

        if(isset($_GET['success']) && $_GET['success'] == 'true') {

            // Get the payment Object by passing paymentId
            // payment id was previously stored in session in
            // CreatePaymentUsingPayPal.php

            $log = PayPalLog::find( Session::get('log_id') );

            $paymentId = $log->payment_id;
            //$payment = Paypalpayment::get($paymentId, $this->_apiContext);
            $payment=Payment::get($paymentId, $this->_apiContext);

            // PaymentExecution object includes information necessary
            // to execute a PayPal account payment.
            // The payer_id is added to the request query parameters
            // when the user is redirected from paypal back to your site
            $execution =Paypalpayment::PaymentExecution();
            $execution->setPayerId($_GET['PayerID']);


            //Execute the payment
            try {
                $order = $payment->execute($execution, $this->_apiContext)->toArray();
            } catch (\PPConnectionException $ex) {
                return "Exception: " . $ex->getMessage() . PHP_EOL;
                var_dump($ex->getData());
                exit(1);
            }

            $payer = $order['payer']['payer_info'];


            $log->state = $order['state'];
            $log->viewed = false;

            $log->paypal_id = $order['id'];
            $log->payer_email = $payer['email'];
            $log->payer_id = $payer['payer_id'];
            $log->payer_first_name = $payer['first_name'];
            $log->payer_last_name = $payer['last_name'];
            $log->shipping_address = json_encode($payer['shipping_address']);

            //note: you'll have to do foreach if you want multiple -v
            $log->item_list = json_encode($order['transactions'][0]);
            $log->total = $order['transactions'][0]['amount']['total'];

            $log->save();

            $cart = Cart::content();
            Cart::destroy();

            Flash::success('Payment Sucsess!');
            return view ('cart.paypalReturn')
                ->with('title' , 'Payment Sucsess!')
                ->with('address' ,$payer['shipping_address'])
                ->with('cart' , $cart)
                ->with('log' , $log);

        } else {
            echo "User cancelled payment.";
        }

        // Flash::success('Payment Sucsess!');
        // return redirect()->action('BooksController@show', [Session::get('bookId')]);


    }

    /**
     * Display the specified resource.
     * Use this call to get details about payments that have not completed,
     * such as payments that are created and approved, or if a payment has failed.
     * url:payment/PAY-3B7201824D767003LKHZSVOA
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $payment = Paypalpayment::getById($payment_id,$this->_apiContext);

        dd($payment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }



    /*
   * Process payment using credit card

    public function store()
    {
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr= Paypalpayment::address();
        $addr->setLine1("3909 Witmer Road");
        $addr->setLine2("Niagara Falls");
        $addr->setCity("Niagara Falls");
        $addr->setState("NY");
        $addr->setPostalCode("14305");
        $addr->setCountryCode("US");
        $addr->setPhone("716-298-1822");

        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType("visa")
            ->setNumber("4758411877817150")
            ->setExpireMonth("05")
            ->setExpireYear("2019")
            ->setCvv2("456")
            ->setFirstName("Joe")
            ->setLastName("Shopper");

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $item1 = Paypalpayment::item();
        $item1->setName('Ground Coffee 40 oz')
            ->setDescription('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setTax(0.3)
            ->setPrice(7.50);

        $item2 = Paypalpayment::item();
        $item2->setName('Granola bars')
            ->setDescription('Granola Bars with Peanuts')
            ->setCurrency('USD')
            ->setQuantity(5)
            ->setTax(0.2)
            ->setPrice(2);


        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item1,$item2));


        $details = Paypalpayment::details();
        $details->setShipping("1.2")
            ->setTax("1.3")
            //total of items prices
            ->setSubtotal("17.5");

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
            // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
            ->setTotal("20")
            ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        dd($payment);
    }
    */
}
